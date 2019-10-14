<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/26
 * Time: 15:32
 */
namespace App\Workerman;
use GatewayWorker\Lib\Gateway;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
class Events{
    public static function onWorkerStart($businessWorker){

    }

    public static function onConnect($client_id){
        /*连接成功 将client存起来备用*/
        //
            Cache::put(Auth::id(),$client_id,1440);
            $obj = new \stdClass();
            $obj->type = 'connect';
            $obj->id = $client_id;
            $obj->login_id = Auth::id();
            $obj->a =Auth::user();

            Gateway::sendToClient($client_id,json_encode($obj,JSON_UNESCAPED_UNICODE));
        //}

    }

    public static function onWebSocketConnect($client_id,$data){}

    public static function onMessage($client_id,$message){}

    public static function onClose($client_id){

    }
}