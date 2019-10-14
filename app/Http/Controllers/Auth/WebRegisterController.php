<?php

namespace App\Http\Controllers\Auth;

use App\Jobs\record;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class WebRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ],
            [
                'name.required' => '用户名不能为空',
                'email.required' => '邮箱不能为空',
                'email.email' => '邮件格式不正确',
                'password.required' => '密码不能为空',
                'password.confirmed' => '两次密码填写不一致',
                'password.min' => '密码至少需要6位',
                'email.unique' => '该邮箱已被注册',
            ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request)
    {

        $error = $this->validator($request->all())->errors()->all();
        if ($error) {
            $error_msg = implode('<br>', $error);
            return response()->json($error_msg);
        }
        $user = $this->create($request->all());
        /*$this->print_arr($user);
        exit;*/
        event(new Registered($user));

        $this->guard()->login($user);
        $post_arr=['register_num'=>1];
        record::dispatch($post_arr);
        return response()->json('success');
    }
}
