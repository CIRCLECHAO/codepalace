<?php

namespace App\Admin\Controllers;

use App\Article;
use App\Category;
use App\Comment;
use App\Http\Controllers\Controller;
use App\Operation;
use App\User;
use Encore\Admin\Layout\Content;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        $date = date('Y-m-d');
        /*折线图 日数据*/
        $daily_data_list = Operation::select('op_date','read_num','article_read_num','profile_read_num','article_write_num')
            ->orderBy('op_date','DESC')
            ->limit(7)
            ->get()
            ->toArray();
        /*转换成3个数组*/
        $daily_data_list = array_reverse($daily_data_list);
        $op_date_list = array_column($daily_data_list,'op_date');
        $read_num_list = array_column($daily_data_list,'read_num');
        $article_read_num_list = array_column($daily_data_list,'article_read_num');
        $article_write_num_list = array_column($daily_data_list,'article_write_num');

        /*今日详情页首页访问比*/
        $today_r = end($read_num_list);
        $today_article_r = end($article_read_num_list );

        $read_percent =(round(($today_article_r/$today_r),4)*100)."%";

//        $profile_read_num_list = array_column($daily_data_list,'profile_read_num');
        $daily_list = [
            'op_date_list'=>$op_date_list,
            'read_num_list'=>$read_num_list,
            'article_read_num_list'=>$article_read_num_list,
            'article_write_num_list'=>$article_write_num_list,
//            'profile_read_num_list'=>$profile_read_num_list,
            ];

        /*饼图 文章分类占比*/
        $article_datas = Article::select(DB::raw('category,COUNT("id") AS num'))
            ->groupBy('category')
            ->get()
            ->toArray();
       // $article_datas_post['total']=0;
        foreach ($article_datas as $article_data){
            $category = Category::find($article_data['category']);
            $article_data['category_name'] =$category->name;
            $article_data['category_color'] ="rgb(".trim($category->color).")";
            $article_data['border_width'] =0;
            //$article_datas_post['total'] += $article_data['num'];
            $article_datas_post[]= $article_data;
        }

        $color_list = array_column($article_datas_post,'category_color');
        $num_list = array_column($article_datas_post,'num');
        $name_list = array_column($article_datas_post,'category_name');
        $width_list = array_column($article_datas_post,'border_width');
//        $profile_read_num_list = array_column($daily_data_list,'profile_read_num');
        $article_datas_post = [
            'num_list'=>$num_list,
            'name_list'=>$name_list,
            'color_list'=>$color_list,
            'border_list'=>$width_list,
        ];




        /*每日数据 最上面四个*/
        $daily_data = Operation::where('op_date','=',$date)->first();
        if(!$daily_data){
            $daily_data=new Operation();
            $daily_data->read_num =0 ;
        }

        /*左侧数据（文章数据）*/
        $max_click = Article::select('click')->orderBy('click','DESC')->first();

        $max_comment = Comment::select(DB::raw('COUNT(*) AS count'))
            ->groupBy('article_id')
            ->orderBy('count','DESC')
            ->first();

        $max_article = Article::select(DB::raw('COUNT(*) AS count,user_id'))
            ->groupBy('user_id')
            ->orderBy('count','DESC')
            ->first();
        $left_data=['max_click'=>$max_click,
                    'max_comment'=>$max_comment,
                    'max_article'=>$max_article
                   ];

        /*中间数据 最活跃的用户*/
        $user = User::find($max_article->user_id);
        $user->article_num=$max_article->count??0;
        $user->be_commented_num = Comment::where('article_user_id','=',$max_article->user_id)->count();
        $user->be_zan_num = Article::where('user_id','=',$max_article->user_id)->sum('zan');

        /*$this->print_arr($user);
        exit;*/

        $show_data = [
                      'good_user'=>$user,
                      'daily_data'=>$daily_data,
                      'daily_list'=>json_encode($daily_list),
                      'read_percent'=>$read_percent??'',
                      'article_datas_post'=>json_encode($article_datas_post,JSON_UNESCAPED_UNICODE)
                     ];
        $show_data=array_merge($show_data,$left_data);
        /*$this->print_arr($show_data);
        exit;*/
        $view = view('admin.dashboard.dashboard',$show_data);

        return $content
            ->header('仪表盘')
            ->description('代码殿堂-仪表盘')
            ->body($view);
    }

    /*图表数据*/
}
