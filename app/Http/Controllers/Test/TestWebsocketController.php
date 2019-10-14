<?php

namespace App\Http\Controllers\Test;

use App\Chat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GatewayClient\Gateway;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\chat\ChatController;
class TestWebsocketController extends Controller
{

    public function test()
    {
        $data['login_id']=Auth::id();
        return view('test.websocket',$data);

    }

    public function bind(Request $request){
        Gateway::$registerAddress = "0.0.0.0:1236";
        $uid = Auth::id();
        if(!$uid){
            return 'no_login';
        }
        $client_id =$request['client_id'];
        Gateway::bindUid($client_id,$uid);
        return Auth::id();
      //  Gateway::joinGroup($client_id, $group_id);
    }

    public function send_message(Request $request){
        Gateway::$registerAddress = '0.0.0.0:1236';
//        保存到数据库
        $chat = new Chat();
        $chat->content = $request['content'];
        $chat->to_id = $request['to_id'];
        $chat->from_id = Auth::id();
        $re = $chat->save();

        // 向任意uid的网站页面发送数据

        $uid = $request['to_id'];
        $message = new \stdClass();
        $message->type='send';
        $message->from=Auth::id();
        $message->from_name=Auth::user()->name;
        $message->from_avatar=Auth::user()->avatar;
        $message->content=$request['content'];
        Gateway::sendToUid($uid, json_encode($message,JSON_UNESCAPED_UNICODE));
        $request['to_uid']=$uid;
        $cc = new ChatController();
        /*返回得到的聊天记录*/
        $record = $cc->get_chat_record($request);

        /*然后将所有的数据置为已读*/
        $yd = $cc->set_read($request);


        return ['result'=>$re,'record'=>$record,'from_id'=>Auth::id(),'to_id'=>$uid,'yd'=>$yd];


//        // 向任意群组的网站页面发送数据
//        Gateway::sendToGroup($group, $message);
    }

}
