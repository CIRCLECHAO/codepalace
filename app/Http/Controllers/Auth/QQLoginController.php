<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Jobs\record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;

class QQLoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        //$this->middleware('record_ip')->except('logout');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function qq(){
        return Socialite::with('qq')->redirect();
    }
    function get_user($qq_token){
        $has = User::where('qq_token','=',$qq_token)
            ->select('*')
            ->first();
        return $has??null;
    }

    public function qq_login(){
        $qq_user = Socialite::driver('qq')->user();
        //dd($qq_user->user);
       // return json_encode($user);
        /*如果已经登录过 直接登录*/

        $qq_token = $qq_user->token;
        $has = $this->get_user($qq_token);
       /* print_r($has);
        exit;*/
        if($has){
            $msg = $this->deal_user_close($has);
            /*print_r($msg);
            exit;*/
            if($msg){
                return Redirect::to('/')->withErrors($msg);
            }

            Auth::loginUsingId($has->id);
        }else{
            /*创建账户并且登录*/
            $user = new User();
            $user->qq_token = $qq_token;
            $user->name = $qq_user->nickname;
            $user->qq_name = $qq_user->nickname;
            $user->avatar = $qq_user->avatar;
            $user->email = (User::max('id')+1).'@codepalace.com';

           // $user->province = $qq_user->user['province'];
           // $user->city = $qq_user->user['city'];
            $user->sex = $qq_user->user['gender']=='男'?1:2;
            $user->birthday = ($qq_user->user['year']).'-01-01';
            if($user->save()){
                $has = $this->get_user($qq_token);

                Auth::loginUsingId($has->id);
            }
        }
        $user = ['last_ip'=>$this->getIp()];
        $post_arr=['login_num'=>1];
        record::dispatch($post_arr);
        User::where('id','=',$has)
            ->update($user);
        return Redirect::back();
    }
}
