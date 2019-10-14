<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Jobs\record;
use Illuminate\Support\Facades\Auth;

class WebLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('record_ip')->except('logout');
    }

    public function login(Request $request)
    {
        $name = $request->input('email');
        $password = $request->input('password');
        if (empty($remember)) {  //remember表示是否记住密码
            $remember = 0;
        } else {
            $remember = $request->input('remember');
        }

        /*判断是否封号*/
        $user = User::select('is_close', 'close_start', 'close_days','id')
            ->where('email', 'LIKE', '%' . $name . '%')
            ->first();

        if ($user) {
            $msg = $this->deal_user_close($user);
            if($msg){
                return $msg;
            }
        } else {
            return '用户名不存在';
        }

        //如果要使用记住密码的话，需要在数据表里有remember_token字段
        $login_result = Auth::attempt(['email' => $name, 'password' => $password], $remember);
        //  dd($login_result);

        if ($login_result) {
            $post_arr = ['login_num' => 1];
            record::dispatch($post_arr);
            return 'success';
        } else {
            return '用户名或者密码错误！';
        }
        //return '登录';

    }


}
