<?php

namespace App\Http\Controllers\Article;

use App\Dynamic;
use App\Jobs\record;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article,App\Category;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth,Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
class ArticleController extends Controller
{
    public function index(){
        if(Auth::guest()){
            return Redirect::back()->withInput()->withErrors("本站不允许游客发言！请登录后操作！");
        }
        /*只有管理员能发布官方*/
        if(Auth::id()!=1){
            $category = Category::where('id', "!=","1")
                ->select('*')
                ->get();
           /* var_dump($category);
            return;*/
        }else{
            $category = Category::all();
        }

        $data=[
            'category'=>$category,
            'html_title'=>'发帖-代码殿堂',
        ];

        return view('article.add_article',$data);

    }

    /*保存文章*/
    public function add_article(Request $request){
        if (Auth::guest()){
            return Redirect::back()->withInput()->withErrors("本站不允许游客发言！请登录后操作！");
        }

        $file_character = $request -> file('title_pic');
        if($file_character&&$file_character->isValid()) {
            $avatar = $file_character->store('/public/'. date('Y-m-d').'/title_pics' );
            //上传的头像字段avatar是文件类型
            $title_pic = Storage::url($avatar);//就是很简单的一个步骤
        }

       $this->validate($request,[
            'title'=>'required|max:50',
            'content'=>'required',
        ]);


        $article = new Article;

        $article->title=Input::get('title');
        $article->content=Input::get('content');
        $article->user_id=Auth::user()->id;
        $article->Category=Input::get('category');
        $article->title_pic=$title_pic??"";

        /*管理员发文自动审核*/
        if($article->user_id==1){
            $article->is_checked=1;
            $article->checked_time = date('Y-m-d H:i:s');
            $article->checked_uid=1;
        }

        $c = DB::table('categories')->select('id')->get();
        $arr = array();
        foreach ($c as $k=>$v){
            $arr[]=$v->id;
        }
        if(!in_array($article->Category,$arr)){
            return Redirect::to('/');
        }
        $add_re = $article->save();
        //rint_r($add_re);
        //return ;
        if($add_re){
            /*保存动态*/
            $param = ['op_type'=>1,'user_id'=>Auth::id(),'op_user_article_id'=>$article->id];
            $this->save_dynamic($param);
            $post_arr=['article_write_num'=>1];
            record::dispatch($post_arr);
            return Redirect::to('/');
        }else{
            return Redirect::back()->withInput()->withErrors("发布失败");
        }

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
}
