/**
 * 与GatewayWorker建立websocket连接，域名和端口改为你实际的域名端口，
 * 其中端口为Gateway端口，即start_gateway.php指定的端口。
 * start_gateway.php 中需要指定websocket协议，像这样
 * $gateway = new Gateway(websocket://0.0.0.0:7272);
 */
ws = new WebSocket("ws://0.0.0.0:2346");
// 服务端主动推送消息时会触发这里的onmessage
ws.onmessage=function (e) {
    var data = eval('(' + e.data + ')');

    var type = data.type||"";
    
    switch (type) {
        case "connect":
            layer.msg('连接成功');

            /*进行id绑定*/
            var url = '/testbind';
            var _token = $("input[name='_token']").val();
            var data_post ={
                client_id:data.id,
                '_token':_token,

            };
            $.post(url,data_post,function (re) {
                console.log(re);
            },'json');
            break;

        case "heart":
           // console.log('心跳检测正常');
           //  $.post(url,data_post,function (re) {
           //  },'json');
            break;
        default:
           // layer.msg(e.data);
    }
};