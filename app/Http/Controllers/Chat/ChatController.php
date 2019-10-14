<?php

namespace App\Http\Controllers\chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GatewayClient\Gateway;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Chat;

class ChatController extends Controller
{
    /*发出一句话*/
    public function add_chat(Request $request)
    {
        $chat = new Chat();
        $chat->content = $request['content'];
        $chat->to_id = $request['to_uid'];
        $chat->from_id = Auth::id();
        $chat->from_name = Auth::user()->name;
        $chat->from_name = Auth::user()->avatar;
        $chat->save();
    }

    /*获取聊天记录*/
    public function get_chat_record(Request $request)
    {
        $to_id = $request['to_uid'];
        $chat_record = Chat::where(function ($query) use ($to_id) {
            $query->where('from_id', '=', Auth::id())
                ->where('to_id', '=', $to_id);
        })->orWhere(function ($query) use ($to_id) {
            $query->where('to_id', '=', Auth::id())
                ->where('from_id', '=', $to_id);
        })->limit(30)
            ->orderBy('created_at', "DESC")
            ->get();
        //$chat_record =
        $request['from_id'] = $request['to_uid'];
        $yd = $this->set_read($request);
        // return ($yd);

        return $chat_record ?? [];
    }

    /*获取聊天过的人*/
    public function get_link_list(Request $request)
    {

    }

    /*设置消息已读 就是指定的人发送的消息全部变成已读*/
    public function set_read(Request $request)
    {
        $from_id = $request['from_id'];
        $to_id = Auth::id();
        $update_num = Chat::where('from_id', '=', $from_id)
            ->where('to_id', '=', $to_id)
            ->update(['read' => 1]);
        return $update_num;
    }
}
