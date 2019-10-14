/*登錄*/
$('.btn_login').click(function () {
    var _token = $("input[name='_token']").val();
    var email = $("#email").val();
    var password = $("#password").val();
    var remember = $("#remember").val();
    var url = "login";
    post_data = {
        'email':email,
        'password':password,
        'remember':remember,
        '_token':_token,
    };
    console.log(post_data);
    $.post(url,post_data,function(data)
    {

        if (data=='success') {
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            parent.layer.close(index); //再执行关闭
            layer.msg('登录成功')
        } else {
            layer.msg('登录失败')
        }

    });


});