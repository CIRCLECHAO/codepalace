<?php

namespace App\Http\Controllers\User;

use App\Comment;
use App\Jobs\record;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article,App\Category;
use DB;
use Illuminate\Support\Facades\Auth;
class ArticleController extends Controller
{



    /*保存评论*/
    public function add_comment(Request $request){
        if (Auth::guest()){
            return Redirect("/")->withInput()->withErrors("本站不允许游客发言！请登录后操作！");
        }
        $comment = new Comment;
        $comment->content = $request->input('content');
        $comment->article_id = $request->input('article_id');
        $comment->user_id = Auth::id();
        /*print_r(Auth::id());
        return;*/
        $comment->article_user_id = Article::find($comment->article_id)['user_id'];
        $comment->save();
        /*添加动态*/
        $param = ['op_type'=>2,'user_id'=>Auth::id(),
                  'op_user_comment_id'=>$comment->id,
                  'article_id'=>$comment->article_id];
        $this->save_dynamic($param);
        $post_arr=['comment_num'=>1];
        record::dispatch($post_arr);
        return Redirect('/article_show'.'/'.$comment->article_id);

    }

    public function me(){
        $c = DB::table('comments as c')
            ->leftJoin('articles as a','c.article_id', '=','m.id')
            ->leftJoin('users as u','c.user_id','=','u.id')
            ->where(['c.article_user_id'=>Auth::id()])
            ->select('c.*','a.title','u.name','a.category')
            ->orderBy('c.create_at','desc')
            ->paginate(30);
        foreach ($c as $k=>$v){
            $find = Category::find($v->category);
            $v->color = $find->color;
            $v->categoryid = $find->id;
            $v->category = $find->name;
            $v->created_at  = $this->t_time($v->created_at);

        }
        return view('user.me')->withc($c);
    }
}
