<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/26
 * Time: 15:32
 */
namespace App\Http\Controllers\Workerman;
use App\Http\Controllers\Controller;
use GatewayWorker\Lib\Gateway;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
class EventsController extends Controller {

    public static function onWorkerStart($businessWorker){

    }

    public static function onConnect($client_id){

        /*没有经过框架 所以无法获取到登录ID*/
            $obj = new \stdClass();
            $obj->type = 'connect';
            $obj->id = $client_id;

            Gateway::sendToClient($client_id,json_encode($obj,JSON_UNESCAPED_UNICODE));
        //}

    }

    public static function onWebSocketConnect($client_id,$data){}

    public static function onMessage($client_id,$message){}

    public static function onClose($client_id){}
}