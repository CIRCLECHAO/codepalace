var user_click=0;
var chat_click=0;
var send_click=0;
var link_tips = '';
var about_tips = '';
var version_tips = '';
var duty_tips = '';
var log_tips = '';
var donate_tips = '';
var friend_tips = '';
var time;

var obj_id='';
var obj_name='';
var obj_avatar='';
var domain = 'https://' + document.domain;


/*百度 自动提交*/
(function () {
        var bp = document.createElement('script');
        var curProtocol = window.location.protocol.split(':')[0];
        if (curProtocol == 'https') {
            bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
        } else {
            bp.src = 'http://push.zhanzhang.baidu.com/push.js';
        }
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(bp, s);
    })();


/*websocket*/
(function () {
        if($('.drop-down-list .menu').children('.login').length>0){
           // $('.login').click();
        }else{
            let protocol = location.protocol === 'https:'
                ? 'wss://codepalace.xyz/wss/'
                : 'ws://0.0.0.0:2346';

        ws = new WebSocket(protocol);
// 服务端主动推送消息时会触发这里的onmessage
        ws.onmessage=function (e) {
            var data = eval('(' + e.data + ')');

            var type = data.type||"";
            Notification.requestPermission();

            switch (type) {
                case "connect":
                   // layer.msg('聊天系统连接成功！');
                    console.log('聊天系统连接成功！');
                    /*进行id绑定*/
                    var url = '/testbind';
                    var _token = $("input[name='_token']").val();
                    var data_post ={
                        client_id:data.id,
                        '_token':_token,
                    };
                    $.post(url,data_post,function (re) {
                        var r=/^[0-9]*$/;
                        if(r.test(re)){
                            console.log('绑定uid:'+re+"成功");
                        }
                    },'json');
                    //查询未接收消息数 并且放置
                    update_total_unread();
                    break;

                case "heart":
                    console.log('心跳检测正常');
                    break;

                    /*接受到消息的处理*/
                case "send":
                    //更新在线聊天按钮
                    update_total_unread();

                    /*更新用户列表*/
                    var _token = $("input[name='_token']").val();
                    post_data = {
                        '_token': _token,
                    };
                    $.post('/get_userlist', post_data, function (data) {

                        var user_list = gene_user_li(data);
                    });
                    /*更新聊天框*/
                    if($('.chat_container').length>0){
                        post_data = {
                            'to_uid':obj_id,
                            '_token': _token,
                        };
                        $.post('/get_chatrecord',post_data,function (re) {
                            /*刷新聊天记录*/
                            param={
                                'uid':obj_id,
                                'name':obj_name,
                                'avatar':obj_avatar,
                            };
                            var content = gene_content(re,param);
                            $('.chat_content_text ul').html(content);
                            $('.chat_content').animate({'scrollTop':$('.chat_content_text').height()+'px'},1000);

                        });
                    }
                        // var hiddenProperty = 'hidden' in document ? 'hidden' :
                        //     'webkitHidden' in document ? 'webkitHidden' :
                        //         'mozHidden' in document ? 'mozHidden' :
                        //             null;
                        //     console.log(!document[hiddenProperty]);
                        //     if (!document[hiddenProperty]) {
                              //  console.log('页面非激活');
                                // 获得权限
                                var icon = '';
                                if(data.from_avatar.indexOf('https')!=-1){
                                    icon = data.from_avatar;
                                }else{
                                    icon = domain+data.from_avatar;
                                }
                                var  notification =  new Notification(data.from_name, {
                                    body: '您有一条新的消息！',
                                    icon: icon
                                });
                                notification.onclick=function () {
                                    window.focus();
                                    //如果没有打开聊天弹框  给他打开
                                    if( $('ul.user_list').length<=0){

                                        $('.chat_button').click();
                                    }
                                    var from_id = data.from_id;
                                    if($('.chat_container').length<=0){
                                        $("li[data-id = "+from_id+"]").click();
                                    }
                                }
                            // }
                break;

                default:
                    layer.msg(e.data);
            }
        };
        }
    })();

/*用户点击事件*/
$(document).on('click','li.user', function () {
        if(chat_click==1){
            return;
        }
        chat_click=1;
        var uid = $(this).attr('data-id');
        var avatar = $(this).children('img').attr('src');
        var name = $(this).text();
        var _token = $("input[name='_token']").val();
        var param = {
            'uid':uid,
            'avatar':avatar,
            'name':name,
        }
        post_data = {
            'to_uid':uid,
            '_token': _token,
        };
        $.post('/get_chatrecord',post_data,function (re) {
            open_chat_container(re,param);
            /*刷新列表*/
            var _token = $("input[name='_token']").val();
            post_data = {
                '_token': _token,
            };
            $.post('/get_userlist', post_data, function (data) {

                var user_list = gene_user_li(data);
            });

        });
    });

/*谷歌广告*/
// (adsbygoogle = window.adsbygoogle || []).push({
//     google_ad_client: "ca-pub-2554959316770518",
//     enable_page_level_ads: true
// });


//选择图片，马上预览
function xmTanUploadImg(obj, id) {
    var file = obj.files[0];

    //console.log(obj);console.log(file);
    // console.log("file.size = " + file.size);  //file.size 单位为byte

    if (file.size > 2097152) {
        layer.msg('上传图片过大！');
        return;
    }

    var reader = new FileReader();

    //读取文件过程方法
    reader.onloadstart = function (e) {
        //console.log("开始读取....");
    }
    reader.onprogress = function (e) {
        //console.log("正在读取中....");
    }
    reader.onabort = function (e) {
        //console.log("中断读取....");
    }
    reader.onerror = function (e) {
        // console.log("读取异常....");
    }
    reader.onload = function (e) {
        //console.log("成功读取....");

        var img = document.getElementById(id);
        img.src = e.target.result;
        //或者 img.src = this.result;  //e.target == this
    }

    reader.readAsDataURL(file)
}

//展示隐藏名片
function show_info(obj) {
    $('div.popup-user-box').hide();
    clearTimeout(time);
    $(obj).children('div.popup-user-box').show();

}

//展示隐藏名片
function hide_info(obj) {
    time = setTimeout(function () {
        $(obj).children('div.popup-user-box').hide();
    }, 1000);
}

//登录方法
function open_login_dom() {
    //页面层-自定义
    layer.open({
        id: 'layer_login_id',
        type: 1,
        title: '登录',
        maxmin: false,
        shadeClose: true, //点击遮罩关闭层
        area: ['350px', '340px'],
        content: login_dcom,
        end: function () {
            location.reload();
        }
    });

    $('.btn_login').click(function () {
        var _token = $("input[name='_token']").val();
        var email = $("#email").val();
        var password = $("#password").val();
        var remember = $("#remember").val();
        var url = "/login";
        post_data = {
            'email': email,
            'password': password,
            'remember': remember,
            '_token': _token,
        };
        console.log(post_data);
        $.post(url, post_data, function (data) {

            // console.log(data);
            //return;
            if (data == 'success') {
                layer.closeAll();
                layer.msg('登录成功')
            } else {
                layer.msg(data)
            }
        });

    });

    /**/
    $('.btn_forget').click(function () {
            //ayer.closeAll();
            //页面层-自定义
            layer.open({
                id: 'layer_send_email_id',
                type: 1,
                title: '找回密码',
                maxmin: false,
                shadeClose: true, //点击遮罩关闭层
                area: ['350px', '340px'],
                content: send_email_dcom,
                /*end: function () {
                    location.reload();
                }*/
            });

            $('.btn_sendemail').click(
                function () {
                    var _token = $("input[name='_token']").val();
                    var email = $("#forget_email").val();
                    var url = "/password/email";
                    post_data = {
                        'email': email,
                        '_token': _token,
                    };
                    // console.log(post_data);
                    var index = layer.load(2, {time: 10 * 1000});
                    $.post(url, post_data, function (data) {

                        // console.log(data);
                        //return;
                        if (data == 'success') {
                            //关闭
                            layer.close(index);
                            layer.msg('发送邮件成功,请查收')
                        } else {
                            //关闭
                            layer.close(index);
                            layer.msg(data)
                        }
                    });
                }
            )
        })

    // $('.login_register').click(function () {
    //     $('.register').click();
    // })
}

//注册方法
function open_register_dom() {
    //页面层-自定义
    layer.open({
        id: 'layer_register_id',
        type: 1,
        title: '注册',
        maxmin: false,
        shadeClose: true, //点击遮罩关闭层
        area: ['350px', '500px'],
        content: register_dcom,
        // end: function () {
        //     location.reload();
        // }
    });

    $('.btn_register').click(function () {
        var _token = $("input[name='_token']").val();
        var name = $("#layer_register_id #username").val();
        var password = $("#layer_register_id #password").val();
        var email = $("#layer_register_id #email").val();
        var password_confirmation = $("#layer_register_id #password-confirm").val();
        var url = "/register";
        post_data = {
            'name': name,
            'email': email,
            'password': password,
            'password_confirmation': password_confirmation,
            '_token': _token,
        };
        console.log(post_data);
        //return;
        $.post(url, post_data, function (data) {

            console.log(data);
            // return;
            if (data == 'success') {
                layer.closeAll();
                layer.msg('注册成功，自动登录中...')
                location.reload();
            } else {
                layer.msg(data)
            }
        });

    });

}

//模糊查询
function index_search(e) {
    var keyword = $('#keyword').val()
    if (!keyword) {
        layer.msg('请输入关键词进行查询！');
        return;
    } else {
        var url = window.location.href;
        if (('http://' + document.domain + '/') == url || ('https://' + document.domain + '/') == url) {
            aim_url = url + '0/2/' + keyword;
        } else {
            var arr = url.split('/');
            if (arr.length == 6) {
                arr.pop();
                str = arr.join('/');
                aim_url = str + '/' + keyword;
            } else {
                aim_url = url + '/' + keyword;
            }
        }
        // layer.msg(aim_url);
        window.location.href = aim_url;
    }


}


/*显示联系方式*/
function show_link_info(e) {
    layer.closeAll();
    //页面层-自定义
    if (link_tips != '') {
        layer.close(link_tips);
        link_tips = '';
    } else {
        link_tips = layer.tips(link_info_dcom, e, {
            tips: [1, '#FFF'],
            time: 0,
            area: ['auto', 'auto'],
            end: function () {
                link_tips = '';
            }
        });
    }

}

/*显示关于本站*/
function show_about_info(e) {
    layer.closeAll();
    //页面层-自定义
    if (about_tips != '') {
        layer.close(about_tips);
        about_tips = '';
    } else {
        about_tips = layer.tips(about_us_dcom, e, {
            tips: [1, '#FFF'],
            time: 0,
            area: ['auto', 'auto'],
            end: function () {
                about_tips = '';
            }
        });
    }

}

/*显示版权声明*/
function show_version_info(e) {
    layer.closeAll();
    //页面层-自定义
    if (version_tips != '') {
        layer.close(version_tips);
        version_tips = '';
    } else {
        version_tips = layer.tips(version_dcom, e, {
            tips: [1, '#FFF'],
            time: 0,
            area: ['auto', 'auto'],
            end: function () {
                version_tips = '';
            }
        });
    }

}


/*显示免责声明*/
function show_duty_info(e) {
    layer.closeAll();
    //页面层-自定义
    if (duty_tips != '') {
        layer.close(duty_tips);
        duty_tips = '';
    } else {
        duty_tips =
            layer.open({
                type: 1,
                closeBtn: 0,
                title: '免责声明',
                maxmin: false,
                shadeClose: true, //点击遮罩关闭层
                area: ['520px', '600px'],
                content: duty_dcom,
                end: function () {
                    duty_tips = '';
                }
            });
        /*  layer.tips(duty_dcom, e, {
          tips: [1,'#FFF'] ,
          time:0,
          area:['auto','auto'],
          end:function () {
              duty_tips='';
          }
      });*/
    }

}

/*显示网站日志*/
function show_log_info(e) {
    layer.closeAll();
    //页面层-自定义
    if (log_tips != '') {
        layer.close(log_tips);
        log_tips = '';
    } else {
        log_tips =
            layer.open({
                type: 1,
                closeBtn: 0,
                title: '网站更新日志',
                maxmin: false,
                shadeClose: true, //点击遮罩关闭层
                area: ['520px', 'auto'],
                content: log_dcom,
                end: function () {
                    log_tips = '';
                }
            });
    }
}

/*显示捐赠本站*/
function show_donation_info(e) {
    layer.closeAll();
    //页面层-自定义
    if (donate_tips != '') {
        layer.close(donate_tips);
        donate_tips = '';
    } else {
        donate_tips = layer.tips(donate_info_dcom, e, {
            tips: [1, '#FFF'],
            time: 0,
            area: ['auto', 'auto'],
            end: function () {
                donate_tips = '';
            }
        });
    }

}

/*显示友情链接*/
function show_friend_link(e) {
    layer.closeAll();
    //页面层-自定义
    if (friend_tips != '') {
        layer.close(friend_tips);
        friend_tips = '';
    } else {
        friend_tips = layer.tips(friend_dcom, e, {
            tips: [1, '#FFF'],
            time: 0,
            area: ['auto', 'auto'],
            end: function () {
                friend_tips = '';
            }
        });
    }
}

/*生成用户列表*/
function gene_user_li(data) {
    var user = '';
    var avatar='';
    for (var i = 0; i < data.length; i++) {
        avatar = data[i].avatar!=''?data[i].avatar:domain+"/images/default_avatar.jpg";
        user += "<li class='user' " +
            "         data-id='" + data[i].id + "'>" +
            " <img src='" + avatar + "'>" + data[i].name ;
        if(data[i].unread_num>'0'){
            user +="<label class='user_unread_num'>"+data[i].unread_num+"</label>"
        }
        user +="</li>";
    }
    if( $('ul.user_list').length>0){

        $('ul.user_list').html(user);
    }
    return user;
}

//打开用户列表弹框
function open_user_container(data){

    user = gene_user_li(data);

    var user_dcom = '<div class="user_list_div"><ul class="user_list">' + user + '</ul></div>';

    var setting_dcom = '<div class="user_setting_div"><img class="chat_setting" src="'+domain+'/images/chat_setting.jpg"></div>';

    user_dcom+=setting_dcom;

    layer.open({
        type: 1,
        anim: 2,
        shade:0,
        closeBtn: 1,
        offset: ['calc(100% - 402px)','calc(100% - 237px)'],
        title: '用户列表',
        maxmin: false,
        //shadeClose: true, //点击遮罩关闭层
        area: ['235px', '400px'],
        content: user_dcom,
        end: function () {
            update_total_unread();
        }
    });
    user_click=0;
    $('.chat_setting').click(function () {
        layer.msg('先占位，有功能在实现');
    });

}

//打开聊天弹框
function open_chat_container(re,param){

    obj_id=param.uid;
    obj_name=param.name;
    obj_avatar=param.avatar;
    var container = '<div class="chat_container">';

    var topper = '<div class="chat_content">' +
        '<div class="chat_content_text" disabled="disabled"><ul>';
    // console.log(re);
    var content = gene_content(re,param);

        topper += content+'</ul></div></div>';

    var middler = '<div class="chat_middle"><img class="face_button" src="'+domain+'/images/face_button.png"></div>';

    var bottomer ='<div class="chat_send" id="chat_send">' +
        '<textarea class="chat_content_send" id="chat_content_send"></textarea></div>';

    var buttoner = '<div class="chat_buttoner">' +
        '<button class="chat_close_button">关闭</button>' +
        '<button class="chat_send_button">发送</button></div>';

    var finaler = '</div>';

    var chat_bottom = container + topper + middler + bottomer + buttoner + finaler ;

    var chat_container = layer.open({
        //展示聊天框
        type: 1,
        anim: 2,
        closeBtn: 1,
       // shade:0,

        title: '与 '+param.name+' 聊天中...',
        maxmin: false,
        //shadeClose: true, //点击遮罩关闭层
        area: ['600px', '500px'],
        content: chat_bottom,
        end: function (){
            obj_id='';
            obj_name='';
            obj_avatar='';
        }
    });
    $('.chat_content').scrollTop($('.chat_content_text').height());
    chat_click=0;
    /*发送按钮,关闭绑定事件 表情按钮事件*/
    $('.chat_close_button').click(
        function () {
            layer.close(chat_container);
        }
    );
    $('.chat_send_button').click(
        function () {
            if(send_click==1){
                layer.msg('您点的太快了！');
                return;
            }
            send_click=1;
            var content = $('.chat_content_send').val();
            var to_id = param.uid;
            var _token = $("input[name='_token']").val();
            if(content==''){
                layer.msg('发送内容不能为空');
                send_click=0;
                return;
            }
            post_data = {
                'to_id':to_id,
                '_token': _token,
                'content': content,
            };
            // 调用发送消息接口
            $.post('/testsend',post_data,function (re) {
                //console.log(re)
                if(re.result){
                   // layer.msg('发送成功');
                }
                /*发送框置空*/
                $('.chat_content_send').val("");
                send_click=0;
                /*刷新聊天记录*/
                var content = gene_content(re.record,param);
                $('.chat_content_text ul').html(content);
                $('.chat_content').animate({'scrollTop':$('.chat_content_text').height()+'px'},1000);
            });

        }
    );

    // qq表情
    $('.face_button').qqFace({   //表情转换
        id: 'facebox',  //表情盒子的ID
        assign: 'chat_content_send',  //给那个id为msg的控件赋值
        path: domain+'/images/arclist/' //表情存放的路径
    });

    $('.chat_content_send').bind('keypress',
        function(event){if(event.keyCode == "13") $('.chat_send_button').click();
    });

}

//替换表情显示
function replace_em(str){
    str = str.replace(/\</g,'&lt;');
    str = str.replace(/\>/g,'&gt;');
    str = str.replace(/\n/g,'<br/>');
    str = str.replace(/\[em_([0-9]*)\]/g,'<img src="'+domain+'/images/arclist/$1.gif" border="0" />');
    return str;
}

//生成聊天数据
function gene_content(re,param){

    var total_content = '';
    var my_avatar = $('.user_avatar img').attr('src');
    for(var i=re.length-1;i>-1;i--){
        var content='';
        var show_content = replace_em(re[i].content);
        /*接收方*/
        if(re[i].from_id==param.uid){
            content = "<li class='left_chat_li'>"
                +'<img class="chat_content_avatar" src="'+param.avatar+'">'
                +param.name+'&nbsp;&nbsp;'
                +re[i].created_at
                +"<br>"
                +'<label class="left_chat_word">'+show_content+'</label>'
                +'<br/></li>';
        }else{
            // 发送方
            content = "<li class='right_chat_li'>"
                // +'我'+'&nbsp;&nbsp;'
                +re[i].created_at
                +'<img class="chat_content_avatar" src="'+my_avatar+'">'
                +"<br>"
                +'<label class="right_chat_word">'+show_content+'</label>'
                +'<br/></li>';
        }
        total_content +=content;
    }
    return total_content;
}

//更新未读数据
function update_total_unread(){
    var _token = $("input[name='_token']").val();
    post_data = {
        '_token': _token,
    };
    $.post('/get_unread_num',post_data,function (data) {
        if(data>'0'){
            $('.total_unread_num').show();
            $('.total_unread_num').html(data);

        }else{
            $('.total_unread_num').hide();
        }
    });
}

//分享
$('.shared-box').mouseenter(function () {
    //$(this).children('#share-1').share();
    $(this).children('.shared-items').show();
})

$('.shared-box').mouseleave(function () {
    $(this).children('.shared-items').hide();
})


/*收藏*/
$('.collection').click(function () {

    //layer.msg($(this).attr('data-id'));
    //console.log($(this).find('span').text());
    var num = $(this).find('span').text();
    var id = $(this).attr('data-id');
    var _token = $("input[name='_token']").val();
    var collection = $(this);


    //console.log(_token);
    if ($(this).hasClass('active')) {
        var del = 1;
        var class_name = 'collection';
        num = Number(num) - 1;

    } else {
        var del = 0;
        var class_name = 'collection active';
        num = Number(num) + 1;

    }
    post_data = {
        'id': id,
        'del': del,
        '_token': _token,
    };

    $.post('/article_collect', post_data, function (data) {
        if (data == ('already_have')) {
            layer.msg('已经收藏过了，请刷新页面');
        } else if (data == ('no_login')) {
            layer.msg('请登录后操作');
        } else {
            collection.attr('class', class_name);
            collection.find('span').text(num);
        }
    });

});

/*赞*/
$('.praise').click(function () {

    //layer.msg($(this).attr('data-id'));
    //console.log($(this).find('span').text());
    var num = $(this).find('span').text();
    var id = $(this).attr('data-id');
    var _token = $("input[name='_token']").val();
    var zan = $(this);


    //console.log(_token);
    if ($(this).hasClass('active')) {
        var del = 1;
        var class_name = 'praise';
        num = Number(num) - 1;

    } else {
        var del = 0;
        var class_name = 'praise active';
        num = Number(num) + 1;

    }

    post_data = {
        'id': id,
        'del': del,
        '_token': _token,
    };

    $.post('/article_zan', post_data, function (data) {
        if (data == ('already_have')) {

            layer.msg('已经赞了，请刷新页面');
        } else if (data == ('no_login')) {
            layer.msg('请登录后操作');
        } else {
            zan.attr('class', class_name);
            zan.find('span').text(num);
        }
    });

});

/*关注*/
$('.attention').click(function () {

        var attention = $(this);
        if ($.trim($(this).text()) == '已关注') {
            /*取关*/
            var type = 2;
            if ($(this).hasClass('btn')) {
                var class_name = 'btn attention pay-attention';

            } else {
                var class_name = 'attention pay-attention';

            }
            var text = '+关注';
        } else {
            /*关注*/
            var type = 1;
            if ($(this).hasClass('btn')) {
                var class_name = 'btn attention already-attention';

            } else {
                var class_name = 'attention already-attention';

            }
            var text = '已关注';

        }

        var id = $(this).attr('data-id');
        var _token = $("input[name='_token']").val();
        post_data = {
            'type': type,
            'id': id,
            '_token': _token,
        };

        $.post('/user/change_focus', post_data, function (data) {
            console.log(data);
            if (data == ('already_have')) {
                layer.msg('已经操作完成，请刷新查看！');
            } else if (data == ('not_attention')) {
                layer.msg('并未关注该用户！,无需取消！');
            } else if (data == ('no_login')) {
                layer.msg('请登录后操作');
            } else if (data == ('cant_focus_self')) {
                layer.msg('不能关注你自己！');
            } else {
                attention.attr('class', class_name);
                attention.text(text);
            }
        });
    });

/*聊天
判断是否登录
1获取用户列表
2选择一个进行聊天*/
$('.chat_button').click(function () {
        if(user_click==1){
            return;
        }
        user_click=1;

        if($('.drop-down-list .menu').children('.login').length>0){
            $('.login').click();
        }else{
            var _token = $("input[name='_token']").val();
            post_data = {
                '_token': _token,
            };

            $.post('/get_userlist', post_data, function (data) {
                //console.log(data);
                open_user_container(data);
            });

        }

    });





