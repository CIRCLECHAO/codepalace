<?php

namespace App\Http\Controllers;
use App\Chat;
use App\Province,App\City,App\Category,App\Article,App\Comment;
use App\Dynamic;
use App\User;
use DB;
use App\Log;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
class ApiMainController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function queryWeatherByCity($location){
        //准备请求参数
        $key ="66f1ee574b86473a9b58d8bf7ecd92ea";
        $curlPost = "key=".$key."&location=".urlencode($location);
        $url = 'https://free-api.heweather.com/s6/weather/now?'.$curlPost;
        //return $url;
        //初始化请求链接
        $req=curl_init();
        //设置请求链接
        curl_setopt($req, CURLOPT_URL,$url);
        //设置超时时长(秒)
        curl_setopt($req, CURLOPT_TIMEOUT,3);
        //设置链接时长
        curl_setopt($req, CURLOPT_CONNECTTIMEOUT,10);
        //设置头信息
        $headers=array( "Accept: application/json", "Content-Type: application/json;charset=utf-8" );
        curl_setopt($req, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($req, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($req, CURLOPT_RETURNTRANSFER, true); // 获取数据返回

        $data = curl_exec($req);
        //print_r($data);
        curl_close($req);
        return json_decode($data);
    }

    //获取访客ip
    public function getIp()
    {
        $ip=false;
        if(!empty($_SERVER["HTTP_CLIENT_IP"])){
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }
            for ($i = 0; $i < count($ips); $i++) {
                if (!preg_match("^(10│172.16│192.168)./i^", $ips[$i])) {
                    $ip = $ips[$i];
                    break;
                }
            }
        }
        return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
    }

    //根据ip获取城市、网络运营商等信息
    public function findCityByIp(){
        $ip = $this->getIp();
        //return $ip;
        $token = 'c566a735acaf83b18a0057d2fa97db8d';
        $url = 'http://api.ip138.com/query/?ip='.$ip.'&datatype=jsonp&callback=find&token='.$token;
        $ch = curl_init($url);//初始化url地址
        curl_setopt($ch, CURLOPT_ENCODING, 'utf8');//设置一个cURL传输选项
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回
        $location = curl_exec($ch);//执行一个cURL会话
        curl_close($ch);//关闭一个cURL会话
       // var_dump($location);
        $location= str_replace('find(','',$location);
        $location= str_replace(')','',$location);
       // var_dump($location);
        return json_decode($location)->data??"";
    }

    //保存动态
    public function save_dynamic($param){


        $dynamic = new Dynamic();
        $dynamic->op_type=$param['op_type'];
        $dynamic->op_user_id=$param['user_id']??Auth::id();

        switch($param['op_type']){
            case 1:
                /*发帖*/
                $dynamic->op_user_article_id = $param['op_user_article_id'];
                break;
            case 2:
                /*评帖*/
                $dynamic->op_user_comment_id = $param['op_user_comment_id'];
                $dynamic->article_id = $param['article_id'];
                break;
            case 3:
                /*赞帖*/
                $dynamic->article_id = $param['article_id'];
                break;
            case 4:
                /*藏帖*/
                $dynamic->article_id = $param['article_id'];
                break;
            case 5:
                /*赞评*/
                $dynamic->article_id = $param['article_id'];
                $dynamic->comment_id = $param['comment_id'];
                break;
            case 6:
                /*回评*/
                $dynamic->op_user_comment_id = $param['op_user_comment_id'];
                $dynamic->article_id = $param['article_id'];
                $dynamic->comment_id = $param['comment_id'];
                break;
        }
        $dynamic->save();
    }

    //访问 登录 以及操作日志
    public function save_log($param){
        $today = date('Y-m-d');
        $ip = $this->getIp();
        $ip_arr = Cache::get($today.'ip_arr')??[];
//        print_r($ip_arr);
//        exit;
        if(in_array($ip,$ip_arr)){
//            print_r('今日记录万');
//            exit;
            return "";
        }else{
            //查看采集结果
            $ql = \QL\QueryList::get('http://www.ip138.com/ips138.asp?ip='.$ip.'&action=2');

            //设置采集规则
            $data=$ql->find('.ul1 li:eq(0)')->text();
            $data=str_replace('本站数据：','',$data);
            $data_arr = explode('  ',$data);
            $position = $data_arr[0]??'';
            $net_from = $data_arr[1]??'';

            if($param['type']==1){
                /*24小时记录一次访问日志*/
                $log = Log::where('IP','=',$ip)
                    ->select(DB::raw('MAX(created_at) as created_at'))
                    ->get()
                    ->toArray();
                /*如果创建时间+5分钟 大于当前时间 表示仍然不需要记录 */
                $created = $log[0]['created_at']??0;
                if(strtotime('+24 hour',strtotime($log[0]['created_at']))>=time()){
                    return '';
                }
                $log_save = new Log();
                $log_save->user_id = Auth::id()??0;
                $log_save->IP = $ip;
                $log_save->type= $param['type'];
                $log_save->position=$position;
                $log_save->net_from= $net_from;
                $re = $log_save->save();
                //保存当日的登录IP:
                $ip_arr = Cache::get($today.'ip_arr')??[];
                $ip_arr[]=$ip;
                Cache::put($today.'ip_arr',$ip_arr,14400);
                return $re;
            }
        }

    }

    //获取登录用户的相关数据
    public function get_user_data_arr(){
        $user_id=Auth::id();
        if(!$user_id){
            return [];
        }
        $user_focus = Auth::user()->focus_ids;
        /*关注用户列表*/
        $user_focus_arr = explode('丨',$user_focus);
        /*评论过的文章ids*/
        $user_comment_obj = Dynamic::where('op_type','=','2')
            ->where('op_user_id','=',$user_id)
            ->select('article_id')
            ->get();
        $user_comment_arr=[];
        foreach ($user_comment_obj as $v){
            $user_comment_arr[]=$v->article_id;
        }

        /*赞过的文章ids*/
        $user_zan_obj = Dynamic::where('op_type','=','3')
            ->where('op_user_id','=',$user_id)
            ->select('article_id')
            ->get();
        $user_zan_arr=[];
        foreach ($user_zan_obj as $v){
            $user_zan_arr[]=$v->article_id;
        }

        /*收藏的文章ids*/
        $user_collect_obj = Dynamic::where('op_type','=','4')
            ->where('op_user_id','=',$user_id)
            ->select('article_id')
            ->get();
        $user_collect_arr=[];
        foreach ($user_collect_obj as $v){
            $user_collect_arr[]=$v->article_id;
        }


        return [
            'user_comment_arr'=>$user_comment_arr,
            'user_focus_arr'=>$user_focus_arr,
            'user_zan_arr'=>$user_zan_arr,
            'user_collect_arr'=>$user_collect_arr,
        ];
    }

    /*日志以及格式化输出*/
    public function self_log($text){
        print_r($text);
       // logger($message)->write($text,true);
        //logger($message)->write("\n",true);
        print_r('</br>');
    }

    /*格式化输出数组*/
    public function print_arr($arr){
        echo "<pre>";print_r($arr);echo "<pre>";
    }

    /*全部人员 去除管理员*/
    public function get_user_list(){
        if(Auth::id()){
            $user_list = User::where('id','<>',Auth::id())->get();
            /*获取每个用户的未读消息*/
            foreach ($user_list as &$user){
                $uid = Auth::id();
                $unread_num = Chat::where('to_id','=',$uid)
                    ->where('from_id','=',$user->id)
                    ->where('read','=',0)
                    ->count();
                if($unread_num>99){
                    $unread_num='99+';
                }
                $user->unread_num=$unread_num??0;
            }
        }else{
            $user_list = User::where('id','>',0)->get();

        }


        return $user_list;
    }

    /*获取用户信息*/
    public function get_user_info($id=""){
        $id = $id??Auth::id();

        $user_info = User::find($id);
        if($user_info->province){
            $user_info->province = Province::select('province_name')
                ->where('province_id','=', $user_info->province)
                ->get()[0]->province_name;
        }
        if($user_info->city){
            $user_info->city = City::select('city_name')
                ->where('city_id','=',$user_info->city)
                ->get()[0]->city_name;
        }
        return $user_info;
    }

    /*获取文章列表*/
    public function get_article_list($id="*",$type="",$keyword=""){
        $category = Category::all();
        $uid = Auth::id();
        $c = DB::table('categories')->select('id')->get();
        $arr = array();
        foreach ($c as $key=>$value){
            $arr[]=$value->id;
        }

        $select=DB::table('articles as a')
            ->leftJoin('users as u','a.user_id',"=","u.id")
            ->leftJoin('categories as  c','a.category','=','c.id')
            ->orderBy('a.is_top','DESC')
            ->orderBy('a.created_at','desc')
            ->orderBy('a.click','DESC')
            ->select('a.*','u.name as user_name','c.name as category_name',
                'c.color','u.avatar','u.description','u.is_expert',
                'u.is_fantastic','u.card_background_image');

            if($uid){
                $select = $select->where(function ($query) use ($uid){
                    $query->where('is_checked','=',0)
                          ->where('user_id','=',$uid)
                          ->orWhere('is_checked','=',1);
                });
            }else{
                $select = $select->where('is_checked','=',1);
            }

        /*我关注的列表*/
        if($type==1){

            $focus_ids = Auth::user()->focus_ids;
            if($focus_ids){
                $focus_ids_arr=  explode('丨',$focus_ids);
                $select = $select
                    ->whereIn('user_id',$focus_ids_arr);
            }else{
                return [];
            }
            /*专家号发表的文章*/
        }elseif ($type==3){
            $expert_ids = User::where('is_expert','=','1')
                ->select('id')
                ->get();
            // return $expert_ids;
            $expert_ids_arr=[];
            if($expert_ids){
                foreach ($expert_ids as $user){
                    // return $user;
                    $expert_ids_arr[] =  $user['id'];
                }

                $select = $select
                    ->whereIn('user_id',$expert_ids_arr);

            }else{
                return [];
            }
        }elseif ($type==4){
            $comment_article_ids=Comment::groupBy('article_id')->get();
            $article_ids_arr=[];
            if($comment_article_ids){
                foreach ($comment_article_ids as $comment){
                    $article_ids_arr[]=$comment['article_id'];
                }
                $select = $select
                    ->whereIn('a.id',$article_ids_arr);
            }else{
                return [];
            }
            //return $article_ids_arr;
        }

        /*如果有关键词查询*/
        if($keyword) {
            $select = $select
                ->where(function ($query) use ($keyword) {
                    $query->where('u.name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('title', 'LIKE', '%' . $keyword . '%');
                });
        }
//        $page = Request::get('page', 1);

        if(!in_array($id,$arr)){
            $articles = $select
                ->paginate(10);
        }else{
            $articles = $select
                ->where('a.category','=',$id)
                ->paginate(10);
        }
        foreach ($articles as $k=>$article){
            $uid = Auth::id();
            /*如果未登录或者非本人的 审核未通过的文章 不展示*/
            /*if(!$uid||($uid!=$article->user_id)){
                if(!$article->is_checked){
                    unset($articles[$k]);
                    continue;
                }
            }*/

            //$article->comments_num=Article::find($article->id)->comments->count('id');

            $article->comments_num=Comment::select('id')
                                          ->where('article_id','=',$article->id)
                                          ->count();



            //$article->article_num=User::find($article->user_id)->articles->count('id');

            $article->article_num=Article::select('id')
                ->where('user_id','=',$article->user_id)
                ->count();

            //$article->comment_num=User::find($article->user_id)->comments->count('id');

            $article->comment_num=Comment::select('id')
                ->where('user_id','=',$article->user_id)
                ->count();
        }
/*$this->print_arr($articles);
        exit;*/

        return $articles;

    }

    /*获取当前城市的天气*/
    public function get_weather(){
        // Cache::forget($ip.'city');

        if(Auth::guest()){
            return null;
        }else{
            $ip = $this->getIp();

            if($ip=='127.0.0.1'||'::1'){
                $city='合肥';
            }else{
                $ip = Auth::user()->last_ip;
                $city = Cache::get($ip.'city');
                if(!$city){
                    $this->self_log('IP','调用了IP接口');
                    $cus_location_info = $this->findCityByIp();
                    $city = $cus_location_info[2];
                }
            }

            Cache::put($ip.'city',$city,480);

        }


        $weather = Cache::get($city.'weather'.date('Y-m-d'));
        //Cache::forget($city.'weather'.date('Y-m-d'));
        //$this->self_log( 'weather',$weather_data);
        if(!$weather){
            $this->self_log('weather','调用了weather接口');
            $weather_data = $this->queryWeatherByCity($city);

            $weather =['basic'=>$weather_data->HeWeather6[0]->basic,
                'now'=>$weather_data->HeWeather6[0]->now] ;
            Cache::put($city.'weather'.date('Y-m-d'),$weather,1440);
            Cache::forget($city.'weather'.date('Y-m-d',strtotime('-1 day')));
        }
//        var_dump($weather);
//        exit;

        return ['weather'=>$weather,'ip'=>$ip];
    }


    /*获取最新的官方说明*/
    public function get_last_admin_article(){
        $article = Article::select('id','user_id','content')
            ->where('category','=',1)
            ->orderby('created_at','desc')
            ->first();
//        print_r($article);
//        exit;
        if($article){
            $article['user'] = User::find($article['user_id']);
            $article['comments_num']=count(Article::find($article['id'])->comments);
        }else{
            $article=null;
        }
        return $article;
    }

    /*获取热评 zan最多的评论吧*/
    public function get_hot_comment(){
        $zan = Comment::max('zan');
        $comment = Comment::where('zan','=',$zan)
            ->limit(1)
            ->orderby('created_at','desc')
            ->get();
        if($comment[0]??null){
            $comment=$comment[0];
            $comment['user']=User::find($comment->user_id);
            $comment['article']=Article::find($comment->article_id);
        }else{
            $comment=[];
        }

        return $comment;
    }

    /*获取热门话题 前5*/
    public function get_hot_category(){
        $uid = Auth::id();
        $c_ids = Article::select(DB::raw('COUNT(id) as count,category'))
                        ->groupBy('category')
                        ->orderBy('count','DESC')
                        ->limit(5);


        if($uid){
            $select = $c_ids->where(function ($query) use ($uid){
                $query->where('is_checked','=',0)
                    ->where('user_id','=',$uid)
                    ->orWhere('is_checked','=',1);
            });
        }else{
            $c_ids = $c_ids->where('is_checked','=',1);
        }

                $c_ids = $c_ids
                        ->get()
                        ->toArray();


        $c_arr=[];
        foreach ($c_ids as $c_id){

//            continue;
            $category = Category::find($c_id['category'])->toArray();
            $category['num']=$c_id['count'];
            $c_arr[]=$category;
        }

        return $c_arr;

    }

    /*获取当前未读消息数量*/
    public function get_unread_num(){
        $id = Auth::id();
        $num = Chat::where('to_id','=',$id)
                   ->where('read','=',0)
                   ->count();
        if($num>99){
            $num='99+';
        }
        return $num;
    }

    /*获取user封禁状态*/
    public function deal_user_close($user){
        $close_time = strtotime($user->close_start);
        $last_day = strtotime('+' . $user->close_days . "day", $close_time);
        $today = time();
        if ($user->is_close && $last_day > $today && $user->close_start) {
            //计算天数
            $timediff = $last_day - $today;
            $days = intval($timediff / 86400);
            //计算小时数
            $remain = $timediff % 86400;
            $hours = intval($remain / 3600);
            //计算分钟数
            $remain = $remain % 3600;
            $mins = intval($remain / 60);
            //计算秒数
            $secs = $remain % 60;
            $time_str = $days . '天' . $hours . '时' . $mins . '分' . $secs . '秒';
            return '账号封禁中，剩余解封时长：' . $time_str;
        } else {
            $s_user = User::find($user->id);
            $s_user->is_close = 0;
            $s_user->close_days = 0;
            $s_user->close_start = '';
            $s_user->save();
            return '';
        }
    }



    /*获取最近更新文章的人*/
    //TODO

    /*热门话题*/
    //TODO

    public function get_age_by_birthday($birthday){
        $birthday = strtotime($birthday);//int strtotime ( string $time [, int $now ] )
        $year = date('Y', $birthday);
        if(($month = (date('m') - date('m', $birthday))) < 0){
            $year++;
        }else if ($month == 0 && date('d') - date('d', $birthday) < 0){
            $year++;
        }
        return date('Y') - $year;
    }



}
