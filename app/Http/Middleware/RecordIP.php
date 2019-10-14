<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class RecordIP
{
    /**
     * Handle an incoming request.
     * 后置中间件 登录后触发（不管成功与否）
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $response = $next($request);

        /*记录登录ip*/
//        $id = User::select('id')->where('email',$request->email)->first();
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
        $ip= $ip ? $ip : $_SERVER['REMOTE_ADDR'];

        $user = ['last_ip'=>$ip];

        User::where('email','=',$request->email)
            ->update($user);

        return $response;
    }
}
