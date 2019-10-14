<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Http\Controllers\ApiMainController as AC;
use App\Jobs\record;
use App\User;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
class ApiController extends AC
{

    public function common(){

        $str = Input::get('str');

        /*全部转小写 urlencode*/
        $sha1HttpString = sha1('ExampleHttpString');

        $signKey = hash_hmac('sha1', 'ExampleKeyTime', 'YourSecretKey');

    }

    /*文章列表*/
    public function index($id='',$type='',$keyword=''){
        /********************************************************************/

        $articles = $this->get_article_list($id,$type,$keyword);

        $data = [
            'articles'=>$articles,
        ];


        /*插入消息队列*/
        $post_arr=['read_num'=>1];

        record::dispatch($post_arr);

        return json_encode($data);
    }

    /*文章详情*/
    public function article_detail($id){
        $category = $this->get_hot_category();
        $user_data_arr = $this->get_user_data_arr();

        $article_show =DB::table('articles as a')
            ->leftJoin('users as u','a.user_id',"=","u.id")
            ->leftJoin('categories as  c','a.category','=','c.id')
            ->select('a.*','u.name as user_name','c.name as category_name',
                'c.color','u.avatar','u.card_background_image','u.description','u.fans_num')
            ->where('a.id','=',$id)
            ->where('is_checked','=',1)
            ->first();
        if(!$article_show){
            return Redirect::back()->withErrors('文章已经不存在啦');

        }
        /*前一篇 后一篇*/
        $article_show->previous_article = Article::where('id','<',$id)->select('id','title')->orderBy('id','desc')->first();
        $article_show->next_article = Article::where('id','>',$id)->select('id','title')->orderBy('id','asc')->first();


        $user_articles = User::find($article_show->user_id)->articles();

        $article_show->article_num = $user_articles->count();

        $user_articles_show = $user_articles->select('id','title')->paginate(5,['*'], 'aPage');


        $hot_comment = $this->get_hot_comment();

        //$user_list = $this->get_user_list();

        $last_admin_article = $this->get_last_admin_article();

        $comments = DB::table('comments as c')
            ->select("c.*","u.name as user_name",'u.avatar','u.card_background_image','u.fans_num','u.description','u.id as user_id')
            ->leftJoin('users as u','c.user_id',"=","u.id")
            ->where("article_id",'=',$id)
            ->orderBy("created_at",'desc');





        $comments_num = $comments->count();

        $comments=$comments ->paginate(5);

        foreach ($comments as $comment){
            $user = User::find($comment->user_id);
            /*发帖数*/
            $comment->article_num =$user->articles()->count();
            /*评论数*/
            $comment->comment_num =$user->comments()->count();
        }

        $this->add_click($id);
        $data=['article_show'=>$article_show,
            'comments_num'=>$comments_num,
            'comments'=>$comments,
            'category'=>$category,
            'c_id'=>$article_show->category,
            'type'=>$type??2,
            'user_articles_show'=>$user_articles_show,
            'last_admin_article'=>$last_admin_article,
            'hot_comment'=>$hot_comment,

            'user_focus_arr'=>$user_data_arr['user_focus_arr']??[],
            'user_comment_arr'=>$user_data_arr['user_comment_arr']??[],
            'user_zan_arr'=>$user_data_arr['user_zan_arr']??[],
            'user_collect_arr'=>$user_data_arr['user_collect_arr']??[],

            'html_title'=>$article_show->title.'-代码殿堂'
        ];

        /*插入消息队列*/
        $post_arr=['article_read_num'=>1];

        record::dispatch($post_arr);
        ////$this->self_log($article_show[0]);
        return json_encode($data);
    }



    /*收藏文章 取消收藏*/
    public function collect_article(Request $request){
        if(!Auth::id()){
            return 'no_login';
        }

        $del = $request['del'];
        $id = $request['id'];
        $article = Article::find($id);
        if($del){
         $re =   Dynamic::where('op_type','=','4')
                ->where('op_user_id','=',Auth::id())
                ->where('article_id','=',$id)
                ->delete();
            if($re!=0&&$article->collect_num>0){
                $article->collect_num--;
            }
        }else{
            $has_article= Dynamic::where('op_type','=','4')
                ->where('op_user_id','=',Auth::id())
                ->where('article_id','=',$id)
                ->count();
            //print_r($has_article);
            //return "";
            if($has_article){
                return 'already_have';
            }

            $param = ['op_type'=>4,'user_id'=>Auth::id(),'article_id'=>$id];
            $re=   $this->save_dynamic($param);
            $article->collect_num++;
        }
        $article->save();
        return $re;

    }

    /*点赞文章 取消点赞*/
    public function zan_article(Request $request){
        if(!Auth::id()){
            return 'no_login';
        }
        $del = $request['del'];
        $id = $request['id'];
        $article = Article::find($id);

        if($del){
          $re =  Dynamic::where('op_type','=','3')
                ->where('op_user_id','=',Auth::id())
                ->where('article_id','=',$id)
                ->delete();
          if($re!=0&&$article->zan>0){
              $article->zan--;
          }
            $post_arr=['zan_num'=>-1];
            record::dispatch($post_arr);
        }else{
            $has_article= Dynamic::where('op_type','=','3')
                ->where('op_user_id','=',Auth::id())
                ->where('article_id','=',$id)
                ->count();
            if($has_article){
                return 'already_have';
            }

            $param = ['op_type'=>3,'user_id'=>Auth::id(),'article_id'=>$id];
            $re =  $this->save_dynamic($param);
            $article->zan++;
            $post_arr=['zan_num'=>1];
            record::dispatch($post_arr);
        }
        $article->save();
        return $re;
    }

    /*點擊數加一*/
    public function add_click($article_id){
        $article = Article::find($article_id);
        $click = $article->click+1;
        $article->click = $click;
        $re = $article->save();
        return $re;
    }
}
