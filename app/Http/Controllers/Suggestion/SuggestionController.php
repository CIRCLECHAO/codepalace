<?php

namespace App\Http\Controllers\Suggestion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Suggestion,App\User;
use Illuminate\Support\Facades\Auth,Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class SuggestionController extends Controller
{
    public function index($my=""){
        if($my=='my'){
            /*我的建议*/
            $suggestions = User::find(Auth::id())
                ->suggestions()
                ->where('type','=',1)
                ->orderBy('created_at','desc')
                ->paginate(5);
        }else{
            $suggestions = Suggestion::where('type','=',1)
                ->orderBy('created_at','desc')
                ->paginate(5);
            }

        foreach ($suggestions as &$suggestion){
            //return $suggestion['id'];
            $suggestion['user_name'] = $suggestion->user->name;

            $suggestion['user_avatar'] = $suggestion->user->avatar;

            $suggestion['response'] = $suggestion->suggestion;
        }
        //return $suggestions;
        $data=['suggestions'=>$suggestions,'html_title'=>'意见反馈-代码殿堂'];
       // return $data;
        return view('suggestion.index',$data);
    }

    public function add(){
        return view('suggestion.add');
    }

    public function save(Request $request){
        if (Auth::guest()){
            return Redirect::to("/")->withInput()->withErrors("请登录后操作！");
        }
        $this->validate($request,[
            'title'=>'required|unique:articles|max:50',
            'content'=>'required',
        ]);
        $suggestion = new Suggestion();

        $suggestion->title=Input::get('title');
        $suggestion->content=Input::get('content');
        $suggestion->user_id=Auth::user()->id;
        $suggestion->variety=Input::get('variety');
        $suggestion->origin_id=0;



        if($suggestion->save()){
            return Redirect::to('suggestion/my');
        }else{
            return Redirect::back()->withInput()->withErrors("提交失败");
        }
    }

    public function detail($id){
        $suggestion = Suggestion::find($id);
        $response = $suggestion->suggestion;
        if($response){
            $response['user_name'] =  Suggestion::find($response['id'])->user->name;
            $response['user_avatar'] =Suggestion::find($response['id'])->user->avatar;
        }




        $suggestion['user_name'] = $suggestion->user->name;
        $suggestion['user_avatar'] = $suggestion->user->avatar;
        //return $suggestions;
        $data=['suggestion'=>$suggestion,'response'=>$response];
        // return $data;
        return view('suggestion.detail',$data);
    }
}
