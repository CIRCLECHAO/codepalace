<?php

namespace App\Http\Controllers\Home;

use App\Admin\Controllers\OperationController;
use App\Article;
use App\Http\Controllers\Controller;
use App\Category;
use App\Jobs\record;
use App\User;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /*文章列表*/
    public function index($id='*',$type="",$keyword=''){
//        print_r('系统升级中');
//        exit;
/********************************************************************/
        if(!Auth::guest()){
            $user_data_arr = $this->get_user_data_arr();
            //$unread_num = $this->get_unread_num();

        }else{
            $user_focus_arr = [];
            if($type==1){
                return Redirect::back()->withErrors('请登录后查看我的关注！');
            }
            $unread_num = 0;

        }

        //return $user_focus_arr;

        $category = $this->get_hot_category();
//        echo '<pre>';
//        print_r($category);
//        echo '<pre>';
//        exit;
        $articles = $this->get_article_list($id,$type,$keyword);
        //return $articles;
        $hot_comment = $this->get_hot_comment();

        $user_list = $this->get_user_list();

        $last_admin_article = $this->get_last_admin_article();
        //return $last_admin_article;
        //$click_articles = Article::select('id','title')->orderBy('click','DESC')->limit(5)->get();

        //$new_articles = Article::select('id','title')->orderBy('created_at','DESC')->limit(5)->get();
        $weather = $this->get_weather();

        $data = [
            //'click_articles'=>$click_articles,
            //'new_articles'=>$new_articles,'articles'=>$articles,
//                'weather'=>$weather['weather'],
//                'city'=>$weather['city'],
                'ip'=>$weather['ip'],
                'articles'=>$articles,
                'category'=>$category,
                'last_admin_article'=>$last_admin_article??null,
                'hot_comment'=>$hot_comment,
                'user_list'=>$user_list,
                'c_id'=>$id,
                'type'=>$type>0?$type:2,
                'keyword'=>$keyword??null,
                'user_focus_arr'=>$user_data_arr['user_focus_arr']??[],
                'user_comment_arr'=>$user_data_arr['user_comment_arr']??[],
                'user_zan_arr'=>$user_data_arr['user_zan_arr']??[],
                'user_collect_arr'=>$user_data_arr['user_collect_arr']??[],
               // 'unread_num'=>$unread_num
        ];

        /*影响访问 暂时不需要*/
       // $r = $this->save_log(['type'=>1]);
       // return $r;

        /*插入消息队列*/
        $post_arr=['read_num'=>1];

        record::dispatch($post_arr);

        return view('home.index2',$data);
    }

    /*文章详情*/
    public function article_show($id){
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
        return view('home.article_show2',$data);
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

