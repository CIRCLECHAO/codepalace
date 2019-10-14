/*
var isLogin = false;
(function() {

    window.mylib = {
        detectmob:function(){
            if (navigator.userAgent.match(/Android/i)
                || navigator.userAgent.match(/webOS/i)
                || navigator.userAgent.match(/iPhone/i)
                || navigator.userAgent.match(/iPad/i)
                || navigator.userAgent.match(/iPod/i)
                || navigator.userAgent.match(/BlackBerry/i)
                || navigator.userAgent.match(/Windows Phone/i)) {
                return true;
            } else {
                return false;
            }
        },
        /!** 分享悬浮框的索引 *!/
        sharedBoxIndex: false,
        noticeBoxIndex: false, // 通知弹出框
        //正在加载状态
        loading:function(isShow){

            if(isShow){
                var str = '';
                str += '<div class="loading">';
                str += '	<div class="loading-box"></div>';
                str += '</div>';

                $('body').append(str);
            }else{
                $('.loading').remove();
            }
        },
        miniload : function(isShow){
            if(isShow){
                var str = '';
                str += '<div class="mini-loading">';
                str += '	<div class="mini-load-box"></div>';
                str += '</div>';

                $('body').append(str);
            }else{
                $('.mini-loading').remove();
            }
        },
        /!**
         * 遮罩层 isOpen 是否打开，true为打开，false为关闭
         *!/
        shade: function(isOpen) {
            var shade = $('.guancha-shade');
            if (shade.length == 0) {
                shade = $('<div class="guancha-shade"></div>')
                $('body').append(shade);
            }
            if (isOpen) shade.show();
            else shade.hide();
        },
        /!**
         * 显示错误信息
         *!/
        showError: function(input, msg) {
            var label = input.next('label.login-error');
            label.html(msg);
            if (!label.hasClass('visibility')) {
                label.addClass('visibility');
            }
        },
        /!**
         * 定位元素相对于屏幕居中
         *!/
        positionCenter: function(obj, width, height) {
            //计算定位
            var winWidth = $(window).width();
            var winHeight = $(window).height();

            var top = 0,
                left = 0,
                position = 'fixed';

            if (winWidth > width) {
                left = (winWidth / 2) - (width / 2);
                position = 'fixed';
            } else {
                left = 0;
                position = 'absolute';
            }
            if (winHeight > height) {
                top = (winHeight / 2) - (height / 2);
                position = 'fixed';
            } else {
                top = 0;
                position = 'absolute';
            }

            obj.css({ 'top': top + 'px', 'left': left + 'px', 'position': position });

        },
        /!**
         * 关闭弹层
         *!/
        closePopup: function() {
            var popup = $('.guancha-popup');
            if (popup.length > 0) popup.remove();
            mylib.shade(false);
        },
        /!**
         * 打开弹层，只允许一个一个弹层的出现
         * data 字符串，支持html,
         *!/
        openPopup: function(data) {
            mylib.shade(true);
            var popup = $('.guancha-popup');
            if (popup.length > 0) popup.remove();

            popup = $('<div class="guancha-popup"></div>');

            var close = $('<a href="javascript:;" class="popup-box-close"></a>'); //关闭按钮
            popup.append(close); //关闭按钮
            close.click(function() {
                mylib.closePopup();
                return false;
            });

            popup.append(data);
            $('body').append(popup);

            //计算定位
            var popupWidth = popup.innerWidth();
            var popupHeight = popup.innerHeight();
            mylib.positionCenter(popup, popupWidth, popupHeight); //定位popup
            popup.show();

            //窗口大小改变时重新计算popup的位置
            $(window).resize(function() {
                mylib.positionCenter(popup, popupWidth, popupHeight); //定位popup
            });
        },
        /!**
         * 自定义confrim弹出框
         * info提示选项
         * cancleTip 取消提示
         * doTip 确认按钮
         *!/
        myConfirm : function(info, cancleTip, doTip, callback){
            mylib.closeConfirm();

            var confirmModule = $('<div class="confirm-module"></div>');
            confirmModule.append('<div class="close"></div>');
            confirmModule.append('<div class="info">'+ info +'</div>');
            confirmModule.append('<div class="button"><button class="cancel">'+ cancleTip +'</button><span class="line"></span><button class="do">' + doTip + '</button></div>');
            $('body').append(confirmModule);

            $('.cancel').click(function(){
                mylib.closeConfirm();
            });
            $('.close').click(function(){
                mylib.closeConfirm();
            });
            $('.do').click(function(){
                if (typeof callback == 'function') {
                    callback.call(this);
                }
            });

            //计算定位
            var cwidth = confirmModule.outerWidth();
            var cheight = confirmModule.outerHeight();
            mylib.positionCenter(confirmModule, 241, cheight); //定位popup
            //confirmModule.show();

            //窗口大小改变时重新计算popup的位置
            $(window).resize(function() {
                mylib.positionCenter(confirmModule, 241, cheight); //定位popup
            });
        },
        /!**
         * 关闭confirm弹出框
         *!/
        closeConfirm : function(){
            $('.confirm-module').remove();

        },
        /!**
         * 消息提示框
         * @param  {[type]} data [提示内容]
         * @param  {[type]} time [消失时间 以秒为单位]
         * @return {[type]}      [description]
         *!/
        msg: function(data, time, opneShade) {
            $('.guancha-msg').remove();
            if(typeof opneShade != 'undefined' && opneShade === true){
                mylib.shade(true);
            }else{
                mylib.shade(false);
            }

            popup = $('<div class="guancha-msg"></div>');

            popup.append(data);
            $('body').append(popup);

            //计算定位
            var popupWidth = popup.innerWidth();
            var popupHeight = popup.innerHeight();
            mylib.positionCenter(popup, popupWidth, popupHeight); //定位popup
            popup.show();

            //窗口大小改变时重新计算popup的位置
            $(window).resize(function() {
                mylib.positionCenter(popup, popupWidth, popupHeight); //定位popup
            });
            if (typeof time == 'undefined') {
                time = 2;
            }
            window.setTimeout(function() {
                popup.hide();
            }, time * 1000);
        },
        /!**
         * 验证，
         * input 文本框队形，type类型,mobile,password
         *!/
        validateInput: function(input, type) {
            switch (type) {
                case 'usernick':
                    var str = input.val();
                    if (!(/^[\u4e00-\u9fa5_a-zA-Z0-9·]+$/.test(str))) {
                        mylib.showError(input, '只能含有汉字、字母、数字下划线');
                        return false;
                    }
                    len = str.length;
                    if (len > 20 || len < 2) {
                        mylib.showError(input, '昵称长度2-20个字符');
                        return false;
                    }
                    return true;
                case 'mobile':
                    if (!(/^1[3456789]{1}\d{9}$/.test($.trim(input.val())))) {
                        mylib.showError(input, '请输入正确的手机号码');
                        return false;
                    }
                    return true;
                case 'password':
                    var len = input.val().length;
                    if (len > 18 || len < 6) {
                        mylib.showError(input, '密码长度6-18位');
                        return false;
                    }
                    return true;
                case 'captcha':
                    if (!(/^\S{4}$/.test(input.val()))) {
                        input.next().next('img').hide();
                        input.next().next('a').hide();
                        mylib.showError(input, '验证码错误');
                        return false;
                    }
                    return true;
                default:
                    return false;
            }
        },
        //检验手机号 框
        validateMobileInput : function(input, code){
            if(code == '86'){
                if (!(/^1[3456789]{1}\d{9}$/.test($.trim(input.val())))) {
                    mylib.showError(input, '请输入正确的手机号码');
                    return false;
                }
            }else{
                if($.trim(input.val()) == ''){
                    mylib.showError(input, '请输入正确的手机号码');
                    return false;
                }
            }
            return true;
        },
        bindPhoneCodeList : function(){
            //点击更换区号
            var prefix = '+';

            var commonArea = {
                "中国":"86",
                "中国台湾": "886",
                "中国香港": "852",
                "中国澳门": "853",
                "美国":"1",
                "俄罗斯":"7",
                "加拿大":"1",
                "澳大利亚":"61",
                "日本":"81",
                "新加坡":"65",
                "英国":"44",
                "德国":"49",
                "马来西亚":"60",
                "新西兰":"64",
                "韩国":"82",
                "法国":"33",
                "泰国":"66",
                "越南":"84",
                "意大利":"39",
                "菲律宾":"63",
                "荷兰":"31",
                "印度尼西亚":"62",
                "柬埔寨":"855",
                "西班牙":"34",
                "瑞典":"46",
                "瑞士":"41",
            };
            var area = {"安哥拉":"244","阿富汗":"93","阿尔巴尼亚":"355","阿尔及利亚":"213","安道尔共和国":"376","安圭拉岛":"1264","安提瓜和巴布达":"1268","阿根廷":"54","亚美尼亚":"374","阿森松":"247","澳大利亚":"61","奥地利":"43","阿塞拜疆":"994","巴哈马":"1242","巴林":"973","孟加拉国":"880","巴巴多斯":"1246","白俄罗斯":"375","比利时":"32","伯利兹":"501","贝宁":"229","百慕大群岛":"1441","玻利维亚":"591","博茨瓦纳":"267","巴西":"55","文莱":"673","保加利亚":"359","布基纳法索":"226","缅甸":"95","布隆迪":"257","喀麦隆":"237","加拿大":"1","开曼群岛":"1345","中非共和国":"236","乍得":"235","智利":"56","中国":"86","哥伦比亚":"57","刚果":"242","库克群岛":"682","哥斯达黎加":"506","古巴":"53","塞浦路斯":"357","捷克":"420","丹麦":"45","吉布提":"253","多米尼加共和国":"1890","厄瓜多尔":"593","埃及":"20","萨尔瓦多":"503","爱沙尼亚":"372","埃塞俄比亚":"251","斐济":"679","芬兰":"358","法国":"33","法属圭亚那":"594","加蓬":"241","冈比亚":"220","格鲁吉亚":"995","德国":"49","加纳":"233","直布罗陀":"350","希腊":"30","格林纳达":"1809","关岛":"1671","危地马拉":"502","几内亚":"224","圭亚那":"592","海地":"509","洪都拉斯":"504","中国香港":"852","匈牙利":"36","冰岛":"354","印度":"91","印度尼西亚":"62","伊朗":"98","伊拉克":"964","爱尔兰":"353","以色列":"972","意大利":"39","科特迪瓦":"225","牙买加":"1876","日本":"81","约旦":"962","柬埔寨":"855","哈萨克斯坦":"327","肯尼亚":"254","韩国":"82","科威特":"965","吉尔吉斯坦":"331","老挝":"856","拉脱维亚":"371","黎巴嫩":"961","莱索托":"266","利比里亚":"231","利比亚":"218","列支敦士登":"423","立陶宛":"370","卢森堡":"352","中国澳门":"853","马达加斯加":"261","马拉维":"265","马来西亚":"60","马尔代夫":"960","马里":"223","马耳他":"356","马里亚那群岛":"1670","马提尼克":"596","毛里求斯":"230","墨西哥":"52","摩尔多瓦":"373","摩纳哥":"377","蒙古":"976","蒙特塞拉特岛":"1664","摩洛哥":"212","莫桑比克":"258","纳米比亚":"264","瑙鲁":"674","尼泊尔":"977","荷属安的列斯":"599","荷兰":"31","新西兰":"64","尼加拉瓜":"505","尼日尔":"227","尼日利亚":"234","朝鲜":"850","挪威":"47","阿曼":"968","巴基斯坦":"92","巴拿马":"507","巴布亚新几内亚":"675","巴拉圭":"595","秘鲁":"51","菲律宾":"63","波兰":"48","法属玻利尼西亚":"689","葡萄牙":"351","波多黎各":"1787","卡塔尔":"974","留尼旺":"262","罗马尼亚":"40","俄罗斯":"7","圣卢西亚":"1758","圣文森特岛":"1784","东萨摩亚(美)":"684","西萨摩亚":"685","圣马力诺":"378","圣多美和普林西比":"239","沙特阿拉伯":"966","塞内加尔":"221","塞舌尔":"248","塞拉利昂":"232","新加坡":"65","斯洛伐克":"421","斯洛文尼亚":"386","所罗门群岛":"677","索马里":"252","南非":"27","西班牙":"34","斯里兰卡":"94","圣文森特":"1784","苏丹":"249","苏里南":"597","斯威士兰":"268","瑞典":"46","瑞士":"41","叙利亚":"963","中国台湾":"886","塔吉克斯坦":"992","坦桑尼亚":"255","泰国":"66","多哥":"228","汤加":"676","特立尼达和多巴哥":"1809","突尼斯":"216","土耳其":"90","土库曼斯坦":"993","乌干达":"256","乌克兰":"380","阿拉伯联合酋长国":"971","英国":"44","美国":"1","乌拉圭":"598","乌兹别克斯坦":"233","委内瑞拉":"58","越南":"84","也门":"967","南斯拉夫":"381","津巴布韦":"263","扎伊尔":"243","赞比亚":"260"};
            var hasClick = false;

            $('.telephone-code').click(function(){
                var that = this;
                if(hasClick == false){
                    var list = '<ul class="telephone-code-list">';
                    list += '<ul class="inner-list">';
                    list += '<li style="font-size:16px; font-weight:bold; color : #333">常用国家或地区</li>';
                    for (var i in commonArea) {
                        var content = i + ' ' + prefix + commonArea[i];
                        list += '<li data-code="'+ commonArea[i] +'">'+ content +'</li>';
                    }
                    list += '</ul>';
                    list += '<ul class="inner-list">';
                    list += '<li style="font-size:16px; font-weight:bold; color : #333">所有国家或地区</li>';
                    for (var i in area) {
                        var content = i + ' ' + prefix + area[i];
                        list += '<li data-code="'+ area[i] +'">'+ content +'</li>';
                    }
                    list += '</ul>';
                    list += '</ul>';
                    var $list = $(list);
                    $list.find('li').click(function(){
                        if(typeof $(this).data('code') == 'undefined') return false;
                        var code = $(this).data('code');
                        $('.telephone-code').find('.code').text(prefix + code);
                        $('.telephone-code').find('.code').attr('data-code', code);
                        hasClick = true;
                    });
                    $(this).append($list);
                    hasClick = true;
                }else{
                    $('.telephone-code-list').remove();
                    hasClick = false;
                }
            });
        },
        /!**
         * 注册
         *!/
        register: function() {
            var lib = mylib;
            $.ajax({
                url: mylib.getUserUrl() + '/main/signup-view',
                type: 'GET',
                dataType: 'jsonp',
                success: function(res) {

                    lib.openPopup(res.data);
                    var form = $('#formRegister');
                    //绑定焦点事件
                    form.find(':text,:password').focus(function() {
                        var labelError = $(this).next('label.login-error');
                        if (labelError.hasClass('visibility')) {
                            labelError.html('');
                            labelError.removeClass('visibility');
                        }
                        if ($(this).attr('id') == 'txtCaptcha' || $(this).attr('id') == 'txtPcCaptcha') {
                            $(this).next().next('img').show();
                            $(this).next().next('a').show();
                        }
                    });
                    form.find('.captcha-img').click();
                    //绑定提交事件
                    form.submit(function() {
                        //验证
                        var result = true;
                        var phoneCode = $('.telephone-code').find('.code').attr('data-code');

                        if (!lib.validateInput(form.find('#txtUserNick'), 'usernick')) result = false;
                        if (!lib.validateMobileInput(form.find('#txtMobile'), phoneCode)) result = false;
                        var pwd = form.find('#txtPassword');
                        var cpwd = form.find('#txtConfirmPassword');
                        lib.validateInput(pwd, 'password');
                        if (cpwd.val() != pwd.val()) {
                            lib.showError(cpwd, '密码不一致');
                            result = false;
                        }
                        if (!lib.validateInput(form.find('#txtCaptcha'), 'captcha')) result = false;

                        if (result === false) return false;
                        var nike_name = $('#txtUserNick').val(),
                            phone_number = $('#txtMobile').val(),
                            captcha = $('#txtCaptcha').val(),
                            password = pwd.val(),
                            repassword = cpwd.val();

                        $.ajax({
                            url: mylib.getUserUrl() + '/main/signup',
                            type: 'GET',
                            dataType: 'jsonp',
                            data: {
                                nike_name: nike_name,
                                phone_number: phone_number,
                                captcha: captcha,
                                password: password,
                                repassword: repassword,
                                phone_code : phoneCode,
                            },
                            success: function(res) {
                                if(res.code == 2) {
                                    mylib.msg(res.message);
                                }else if (res.code === 0) {
                                    lib.closePopup();
                                    window.location.reload(true);
                                } else {
                                    for (var key in res.data) {
                                        if(key == 'txtCaptcha'){
                                            form.find('#' + key).next().next('a').hide();
                                        }
                                        lib.showError(form.find('#' + key), res.data[key][0]);

                                    }
                                }
                            }
                        });
                        return false;
                    });

                    //获取验证码
                    var time;
                    var isSend = false;
                    form.find('.get-code').click(function(event) {
                        var check = true;
                        var phoneNumber = $.trim($('#txtMobile').val());
                        var phoneCode = $.trim($('.telephone-code').find('.code').attr('data-code'));
                        var pcCaptcha = $.trim($('#txtPcCaptcha').val());

                        if (!mylib.validateMobileInput($("#txtMobile"), phoneCode)) {
                            check = false;
                        }

                        if($.trim($("#txtPcCaptcha").val()) == ''){
                            $("#txtPcCaptcha").next().next('img').hide();
                            $("#txtPcCaptcha").next('.login-error').text('请先输入图片验证码');
                            $("#txtPcCaptcha").next('.login-error').addClass('visibility');
                            check = false;
                        }else if (!mylib.validateInput($("#txtPcCaptcha"), 'captcha')) {
                            $("#txtPcCaptcha").next().next('img').click();
                            check = false;
                        }
                        if (check) {
                            //获取验证码
                            var that = $(this);
                            if (!isSend) {
                                $.ajax({
                                    url: mylib.getUserUrl() + '/user/send-phone-message',
                                    type: 'post',
                                    dataType: 'json',
                                    xhrFields: {
                                        withCredentials: true
                                    },
                                    data: {
                                        'pcCaptcha' : pcCaptcha,
                                        'phoneNumber': phoneNumber,
                                        'phoneCode' : phoneCode,
                                    },
                                    success: function(res) {

                                        if (res.code == 0) {
                                            mylib.msg('发送成功', 2 ,true);
                                            isSend = true;
                                            //发送成功后倒计时
                                            var countdown = 60;
                                            that.html(countdown + 's');
                                            window.clearInterval(time);
                                            time = setInterval(function() {
                                                if (countdown <= 0) {
                                                    that.html('获取验证码');
                                                    isSend = false;
                                                    window.clearInterval(time);
                                                } else {
                                                    countdown--;
                                                    that.html(countdown + 's');
                                                }
                                            }, 1000);
                                        } else {
                                            isSend = false;
                                            mylib.msg(res.message, 2, true);
                                            $("#txtPcCaptcha").next().next('img').click();
                                        }
                                    }
                                });
                            }

                        }
                        return false;

                    });
                    mylib.bindPhoneCodeList();

                }
            });
        },
        /!**
         * 重置密码
         *!/
        resetPassword: function() {
            var lib = mylib;
            $.ajax({
                url: mylib.getUserUrl() + '/main/reset-password-view',
                type: 'GET',
                dataType: 'jsonp',
                success: function(res) {

                    mylib.closePopup();
                    mylib.shade(true);
                    var popup = $(res.data);
                    popup.css('z-index', 1000);
                    var close = popup.find('.close'); //关闭按钮

                    close.click(function() {
                        popup.remove();
                        mylib.shade(false);
                        return false;
                    });


                    $('body').append(popup);

                    //计算定位
                    var popupWidth = popup.innerWidth();
                    var popupHeight = popup.innerHeight();
                    mylib.positionCenter(popup, popupWidth, popupHeight); //定位popup
                    popup.show();

                    //窗口大小改变时重新计算popup的位置
                    $(window).resize(function() {
                        mylib.positionCenter(popup, popupWidth, popupHeight); //定位popup
                    });
                    var form = $('#formReset');
                    //绑定焦点事件
                    form.find(':text,:password').focus(function() {
                        var labelError = $(this).next('label.login-error');
                        if (labelError.hasClass('visibility')) {
                            labelError.html('');
                            labelError.removeClass('visibility');
                        }
                        if ($(this).attr('id') == 'txtCaptcha' || $(this).attr('id') == 'txtPcCaptcha') {
                            $(this).next().next('img').show();
                            $(this).next().next('a').show();
                        }
                    });
                    form.find('.captcha-img').click();
                    //绑定提交事件
                    form.submit(function() {
                        //验证
                        var result = true;

                        //if (!lib.validateInput(form.find('#txtMobile'), 'mobile')) result = false;
                        var phoneCode = $('.telephone-code').find('.code').attr('data-code');

                        if (!lib.validateMobileInput(form.find('#txtMobile'), phoneCode)) result = false;
                        var pwd = form.find('#txtPassword');
                        var cpwd = form.find('#txtConfirmPassword');
                        lib.validateInput(pwd, 'password');
                        if (cpwd.val() != pwd.val()) {
                            lib.showError(cpwd, '密码不一致');
                            result = false;
                        }
                        if (!lib.validateInput(form.find('#txtCaptcha'), 'captcha')) result = false;

                        if (result === false) return false;
                        var phone_number = $('#txtMobile').val(),
                            captcha = $('#txtCaptcha').val(),
                            password = pwd.val(),
                            repassword = cpwd.val();

                        $.ajax({
                            url: mylib.getUserUrl() + '/main/reset-password',
                            type: 'GET',
                            dataType: 'jsonp',
                            data: {

                                phone_number: phone_number,
                                captcha: captcha,
                                password: password,
                                repassword: repassword,
                                phone_code : phoneCode,
                            },
                            success: function(res) {
                                if (res.code === 0) {
                                    lib.msg('重置成功');
                                    popup.remove();
                                    window.location.reload(true);

                                } else {
                                    for (var key in res.data) {
                                        if(key == 'txtCaptcha'){
                                            form.find('#' + key).next().next('a').hide();

                                        }
                                        lib.showError(form.find('#' + key), res.data[key][0]);

                                    }
                                }
                            }
                        });
                        return false;
                    });
                    //获取验证码
                    var time;
                    var isSend = false;
                    form.find('.get-code').click(function(event) {
                        var check = true;
                        var phoneNumber = $.trim($('#txtMobile').val());
                        var phoneCode = $.trim($('.telephone-code').find('.code').attr('data-code'));
                        var pcCaptcha = $.trim($('#txtPcCaptcha').val());
                        if (!mylib.validateMobileInput($("#txtMobile"), phoneCode)) {
                            check = false;
                        }

                        if($.trim( $("#txtPcCaptcha").val()) == ''){
                            $("#txtPcCaptcha").next().next('img').hide();
                            $("#txtPcCaptcha").next('.login-error').text('请先输入图片验证码');
                            $("#txtPcCaptcha").next('.login-error').addClass('visibility');
                            check = false;
                        }else if (!mylib.validateInput($('#txtPcCaptcha'), 'captcha')) {
                            $("#txtPcCaptcha").next().next('img').click();
                            check = false;
                        }
                        if (check) {
                            //获取验证码
                            var that = $(this);
                            if (!isSend) {
                                $.ajax({
                                    url: mylib.getUserUrl() + '/user/send-phone-message',
                                    type: 'post',
                                    dataType: 'json',
                                    xhrFields: {
                                        withCredentials: true
                                    },
                                    data: {
                                        'pcCaptcha' : pcCaptcha,
                                        'phoneNumber': phoneNumber,
                                        'phoneCode' : phoneCode,
                                    },
                                    success: function(res) {
                                        if (res.code == 0) {
                                            mylib.msg('发送成功', 2 ,true);
                                            isSend = true;
                                            //发送成功后倒计时
                                            var countdown = 60;
                                            that.html(countdown + 's');
                                            window.clearInterval(time);

                                            time = setInterval(function() {
                                                if (countdown <= 0) {
                                                    that.html('获取验证码');
                                                    isSend = false;
                                                    window.clearInterval(time);
                                                } else {
                                                    countdown--;
                                                    that.html(countdown + 's');
                                                }
                                            }, 1000);
                                        } else {
                                            isSend = false;
                                            mylib.msg(res.message, 2, true);
                                            $("#txtPcCaptcha").next().next('img').click();
                                        }
                                    }
                                });
                            }
                        }
                        return false;
                    });
                    mylib.bindPhoneCodeList();
                }
            });
        },
        /!**
         * 登录
         *!/
        login: function(callback) {
            var lib = mylib;
            $.ajax({
                url: mylib.getUserUrl() + '/main/login-view',
                type: 'GET',
                dataType: 'jsonp',
                data : {redirectUrl : encodeURIComponent(window.location.href)},
                success: function(res) {
                    lib.openPopup(res.data);
                    var form = $('#formLogin');

                    //绑定焦点事件
                    form.find(':text,:password').focus(function() {
                        var labelError = $(this).next('label.login-error');
                        if (labelError.hasClass('visibility')) {
                            labelError.html('');
                            labelError.removeClass('visibility');
                        }
                        if ($(this).attr('id') == 'txtCaptcha') {
                            $(this).next().next('img').show();
                            $(this).next().next('a').show();
                        }
                    });
                    //点击忘记密码
                    form.find('.forget-pwd').click(function() {

                        mylib.resetPassword();
                    });
                    //绑定提交事件
                    form.submit(function() {
                        var result = true;
                        var phoneCode = $('.telephone-code').find('.code').attr('data-code');

                        if (!lib.validateMobileInput(form.find('#txtMobile'), phoneCode)) result = false;
                        var pwd = form.find('#txtPassword');
                        if (!lib.validateInput(pwd, 'password')) result = false;

                        if (!lib.validateInput(form.find('#txtCaptcha'), 'captcha')) result = false;

                        if (result === false) return false;

                        var phone_number = $('#txtMobile').val(),
                            password = $('#txtPassword').val(),
                            verifyCode = $('#txtCaptcha').val();
                        rememberMe = $('#checboxMember').is(':checked') ? 1 : 0;

                        $.ajax({
                            url: mylib.getUserUrl() + '/main/login',
                            type: 'GET',
                            dataType: 'jsonp',
                            data: {
                                phone_number: phone_number,
                                password: password,
                                verifyCode: verifyCode,
                                rememberMe: rememberMe,
                                phone_code : phoneCode,
                            },
                            success: function(res) {
                                if (res.code === 0) {
                                    isLogin = true;
                                    lib.closePopup();
                                    if (typeof callback == 'function') {
                                        callback.call(this);
                                    }

                                } else {
                                    $('.captcha').find('img').click();
                                    for (var key in res.data) {
                                        var input = form.find('#' + key);
                                        if (key == 'txtCaptcha') {
                                            input.next().next('img').hide();
                                        }
                                        lib.showError(input, res.data[key][0]);

                                    }
                                }

                            }
                        });

                        return false;
                    });
                    mylib.bindPhoneCodeList();
                }
            });
        },
        getCookie: function(name) {
            var cookieName = encodeURIComponent(name) + '=';
            var cookieStart = document.cookie.indexOf(cookieName);
            cookieValue = null;
            if (cookieStart > -1) {
                var cookieEnd = document.cookie.indexOf(';', cookieStart);
                if (cookieEnd == -1) {
                    cookieEnd = document.cookie.length;
                }
                cookieValue = decodeURIComponent(document.cookie.substring(cookieStart + cookieName.length, cookieEnd));
            }
            return cookieValue;
        },

        setCookie: function(name, value, path, domain, expires, secure) {
            var cookieText = encodeURIComponent(name) + '=' + encodeURIComponent(value);
            if (path) {
                cookieText += '; path=' + path;
            }
            if (domain) {
                cookieText += '; domain=' + domain;
            }
            if (expires) {
                if (expires instanceof Date) {
                    cookieText += '; expires=' + expires.toGMTString();
                }
            }
            if (secure) {
                cookieText += '; secure';
            }
            document.cookie = cookieText;
        },
        getQueryString: function(name) {
            var reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)', 'i');
            var r = window.location.search.substr(1).match(reg);
            if (r != null) {
                return unescape(r[2]);
            }
            return null;
        },
        //    getQueryString : function(key) {
        //    var url = window.location.search;
        //    if (url.indexOf("?") != -1) {		//存在?号
        //       var str = url.substr(1);		//去掉?号
        //       strs = str.split("&");
        //       for(var i = 0; i < strs.length; i ++) {
        //       	 var item = strs[i].split("=");
        //          if(item.length == 2){
        //         	if(item[0] == key){
        //                    return decodeURIComponent(item[1]);
        //                }
        //       	 }
        //       }
        //          return null;
        //    }
        //    return null;
        // },
        init: function() {
            if (mylib.getCookie('GCZWU') != null) {
                isLogin = true;
            }
            if (isLogin) {
                //$('.un-login-state').hide();
                //$('.login-state').show();
            }

            bindNoticeLayOut();
            addGoBack();
        },
        checkLogin: function() {
            if (!isLogin) {
                mylib.login(function() {
                    window.location.reload(true);
                });
                return false;
            } else {
                return true;
            }
        },
        sendPostAjax: function(url, data, callback) {
            if (!mylib.checkLogin()) return;
            $.ajax({
                url: url,
                type: "POST",
                dataType: 'json',
                xhrFields: {withCredentials: true},
                data: data,
                success: function(res) {
                    if (res.code == 203) {
                        isLogin = false;
                        mylib.checkLogin()
                        return;
                    }
                    if (typeof callback == 'function') {
                        callback(res);
                    }
                }
            });
        },
        sendGetAjax: function(url, callback) {
            if (!mylib.checkLogin()) return;
            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                data: {},
                success: function(res) {
                    if (typeof callback == 'function') {
                        callback(res);
                    }
                }
            });
        },
        interact: function(action, actionType, obj, showNumer) {

            var number = parseInt($(obj).find('span').text());
            if (isNaN(number)) {
                number = 0;
            }
            if (actionType == 'cancel') {
                number--;
                if (number <= 0) {
                    number = '';
                }
                if (showNumer === true) {
                    $(obj).html(action + ' <span>' + number + '</span>');
                } else { //没传 或者为false
                    $(obj).html(action);
                }

                $(obj).removeClass('active');
            } else {
                number++;
                if (showNumer === true) {
                    //$(obj).html('取消' + action + ' <span>' + number + '</span>');
                    $(obj).html(action + ' <span>' + number + '</span>');
                } else {
                    //$(obj).html('取消' + action);
                    $(obj).html(action);
                }

                $(obj).addClass('active');
            }
        },
        collect: function(codeId, codeType, from, obj) { //收藏
            if (!mylib.checkLogin()) return;
            $.ajax({
                url: '/post/collect',
                type: 'GET',
                dataType: 'jsonp',
                data: { 'codeId': codeId, 'codeType': codeType, 'from' : from},
                success : function function_name(res) {
                    if (res.code == 0) {
                        mylib.interact('收藏', res.data.action, obj, true);
                    }
                }
            });
        },
        praise: function(postId, obj) { //主帖点赞

            this.sendPostAjax('/post/praise-and-tread', { 'actionType': 1, 'postId': postId }, function(res) {
                if (res.code == 0) {
                    mylib.interact('赞', res.data.action, obj, true);
                }
            })

        },

        // praiseComment: function(commentId, obj) { //赞评论

        //    this.sendPostAjax('/comment/praise', {'id': commentId }, function(res) {
        //        if (res.code == 0) {
        //            mylib.interact('赞', res.data.action, obj, true);
        //        }
        //    })

        // },
        tread: function(postId, obj) { //踩主帖

            this.sendPostAjax('/post/praise-and-tread', { 'actionType': 2, 'postId': postId }, function(res) {
                if (res.code == 0) {
                    mylib.interact('踩', res.data.action, obj, true);
                }
            })

        },
        treadComment: function(commentId, obj) { //踩评论

            this.sendPostAjax('/comment/praise-and-tread', { 'actionType': 2, 'commentId': commentId }, function(res) {
                if (res.code == 0) {
                    mylib.interact('踩', res.data.action, obj, true);
                }
            })

        },
        /!**
         * 举报
         * @param  {[type]} accusationObj   [举报对象 accusation_post accusation_comment ]
         * @param  {[type]} accusationObjId [举报对象id]
         * @param  {[type]} accusationType  [举报类型]
         * @return {[type]}                 [description]
         *!/
        accusation: function(accusationObj, accusationObjId, accusationType, obj) {

        },
        //获取根域名
        getRootDomain : function() {
            var temp = document.domain.split(".");
            return temp[temp.length - 2] + '.' + temp[temp.length - 1];

        },
        getUrl : function (key){
            //return  'http://'+key+'.'+ this.getRootDomain();
            return  '//'+key+'.'+ this.getRootDomain();
        },
        getUserDataByCookie:function(){
            //从COOKIE中获取用户信息，假如值为NULL，则用户没登陆
            var name = 'GCZWU';
            var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
            if(arr=document.cookie.match(reg)) {
                var user=arr[2].split("-");
                //返回用户信息数据，0为用户ID，1为用户名
                return user;
            }
            else return false;
        },
        getUserUrl : function(){
            return this.getUrl('user');
        }


    };

    var initRes = mylib.init(); //初始化

    //注册
    $(document).on('click', '.popup-register', function() {
        mylib.register();

        return false;
    });

    //发帖
    $('.top-nav-fatie > a').click(function() {
        //if (!mylib.checkLogin()) return;
        $.ajax({
            url: '/post/index',
            type: "POST",
            dataType: 'json',
            data: {},
            success: function(res) {
                if (res.code == 203) {
                    isLogin = false;
                    mylib.login(function() {
                        window.location.href = '/post/index';
                    });
                    return;
                }else{
                    window.location.href = '/post/index';
                }

            }
        });
        return false;
    });

    //登录
    $(document).on('click', '.popup-login', function() {
        mylib.login(function() {
            window.location.reload(true);
        });

        return false;
    });


    //点击头像弹出下拉框
    $('.user-nav').on('click', '.avatar', function(ev) {
        layOutHide();
        $('.drop-down-list').toggle();
        return false;
    });


    //下拉框阻止冒泡。防止点击下拉框也会关闭
    $('.drop-down-list').click(function(ev) {
        ev.stopPropagation();
    })
    //弹出框阻止冒泡。防止点击弹出框本身也会关闭
    // $('body').on('click', '.layui-layer', function(event) {
    //     event.stopPropagation();
    // });
    //点击其他地方关闭下拉框
    $(document).click(function(ev) {
        layOutHide();
    });

    //var timeOut;
    $(document).on('mouseover', '.popup-user > img', function() {
        var self = $(this).parent();
        var fromweibo = self.data('fromweibo');
        if(fromweibo == true){
            return false;
        }
        $(this).css({'cursor' : 'pointer'});
        clearTimeout(this.timeOut);

        var popup = self.find('.popup-user-box');
        if (popup.length > 0) {
            popup.show();
            return;
        }

        var uid = self.data('uid') || self.attr('user-id');
        if (typeof uid == 'undefined') return;

        //创建HTML
        popup = $('<div class="popup-user-box"></div>');
        popup.hide();
        popup.append('<div class="icon"></div>');

        popup.mouseenter(function(){
            var img = $(this).prev('img');
            clearTimeout(img.prop('timeOut'));
        }).mouseleave(function(){
            popup.fadeOut(250);
        })

        var userUrl = mylib.getUserUrl();
        $.post(userUrl + '/user/get-user-info', { id: uid }, function(res) {
            if (res.code != 0) return;
            res = res.data;
            var userTop = $('<div class=user-info-top></div>');
            var userInfo = $('<div class="user-info-main clearfix"></div>');

            //user-photo
            var userPhoto = $('<div class="user-photo"></div>');
            var tmp = $('<img />');
            tmp.attr('src', res.user_photo);
            tmp.css({'cursor': 'pointer'});
            tmp.click(function(){
                window.open(userUrl + "/user/personal-homepage?uid=" + uid,"_blank");
            })
            userPhoto.html(tmp);
            userInfo.append(userPhoto);

            //user-main
            var userMain = $('<div class="user-main"></div>');
            tmp = $('<div class="user-nick"></div>');
            tmp.html('<a href="'+ userUrl +'/user/personal-homepage?uid=' + uid + '" target="_blank">' + res.user_nick + '</a>');
            userMain.append(tmp);
            tmp = $('<div class="user-other"></div>');

            if (res.user_description == null) {
                res.user_description = '';
            }
            tmp.html('<p>' + res.user_description + '</p>');
            userMain.append(tmp);
            userInfo.append(userMain);

            //user-interact
            var userInteract = $('<div class="user-info-interact clearfix"></div>');
            userInteract.append('<div class="box"><span>发帖</span><span>' + res.post_count + '</span></div>');
            userInteract.append('<div class="line"></div>');
            userInteract.append('<div class="box"><span>评论</span><span>' + res.comment_count + '</span></div>');
            userInteract.append('<div class="line"></div>');
            userInteract.append('<div class="box"><span>粉丝</span><span>' + res.fans_count + '</span></div></div>');
            userInfo.append(userInteract);

            userTop.append(userInfo);
            popup.append(userTop);

            //bottom
            var user = mylib.getUserDataByCookie();
            var loginUid = user[0];
            if(loginUid != uid){        //登录用户和弹出框所属用户不同的时候 才显示footer
                var footer = $('<div class="user-info-bottom clearfix"></div>');
                if (res.has_attention)
                    footer.append('<div class="attention">已关注</div>');
                else {
                    var pay = $('<div class="attention pay-attention">关注</div>');
                    pay.click(function() {

                        mylib.sendPostAjax(userUrl + '/user/attention', { to_user_id: uid }, function(res) {
                            if (res.code == 0) {
                                if (res.data.action == 'set') {
                                    pay.html('已关注');
                                } else if (res.data.action == 'cancel') {
                                    pay.html('关注');
                                }
                            }
                        });
                    });
                    footer.append(pay);
                }


                footer.append('<div class="line"></div>');
                footer.append('<div class="message"><a target="_blank" href="'+ userUrl +'/user/my-message?to_uid=' + uid + '">私信</a></div>');

                popup.append(footer);
            }

            self.append(popup);
            popup.fadeIn(250);
        });


    }).on('mouseout', '.popup-user > img', function() {
        var self = $(this).parent();
        this.timeOut = setTimeout(function() {
            $('.popup-user-box').fadeOut(250);
        }, 500);

    }).on('click', '.popup-user > img', function(){
        var userUrl = mylib.getUserUrl();
        var self = $(this).parent();
        var uid = self.data('uid') || self.attr('user-id');
        var fromweibo = self.data('fromweibo');
        if(fromweibo == true){
            return false;
        }
        window.open(userUrl + "/user/personal-homepage?uid=" + uid,"_blank");
    });

    function layOutHide() {
        $('.notice-box').hide();
        $('.drop-down-list').hide();
        $('.search-layout').hide();
        //$('.shared-tips').hide();
    }
    /!**
     * 绑定通知提醒
     *!/
    var hasClickNotice = false;

    function bindNoticeLayOut() {
        var lay, enterTimer, leaveTimer, str, userInfo = [];

        $('.user-nav').on('click', '.notice', function(event) {
            var that = this;
            if (!hasClickNotice) {
                $.ajax({
                    url: '/resource/get-notice',
                    type: 'POST',
                    dataType: 'html',
                    data: {},
                    success: function(res) {
                        var str = res;
                        layOutHide();
                        $('.login-state>li.notice').append(res);
                        hasClickNotice = true;
                    }
                });
            } else {
                layOutHide();
                hasClickNotice = false;;
            }


            return false;
        });
        $('.user-nav').on('click', '.notice-box', function(event) {
            event.stopPropagation();
        });
        //点击其他地方关闭下拉框
        $(document).click(function(ev) {
            //$('.notice-box').hide();
            layOutHide();
            hasClickNotice = false;

        });
        //点击一条提醒 后去掉提醒框
        $('.notice').on('click', '.notice-item', function() {
            $(this).closest('.notice-box').remove();
            hasClickNotice = false;
        });
        //点击清除全部通知按钮
        $('.user-nav').on('click', '.clear-all-notice', function(event) {
            var that = this;
            $.ajax({
                url: '/user/clear-all-notice',
                type: 'POST',
                dataType: 'json',
                data: {},
                success: function(res) {
                    if(res.code == 0){
                        //清空列表
                        $(that).closest('.notice-box').find('li').remove();
                        $('.notice').find('.tip').remove();
                    }
                }
            });
            return false;
        });
    }
    //验证码
    $('body').on('click', '.captcha-img', function() {
        this.src = this.src + '?' + Math.random();
        //var url = '/main/captcha?refresh=1';
        //var that = $(this);

        //$.get(url, function(res) {
        // that.attr('src', res.url);
        //});

    });
    var indexShareArr = [],
        commentShareArr = [];

    function removeCssLink(cssFileName){
        $('head').find('link[href*='+cssFileName+']').remove();
    }

    function shareLayOut(container){
        var shareTimeOut;
        $('body').on('mouseenter', container, function(e) {
            window.clearTimeout(shareTimeOut);
            $(this).find('.shared-items').show();
        });
        // $('body').on('mouseenter', container, function(e) {
        //     window.clearTimeout(shareTimeOut);
        // });
        $('body').on('mouseleave', container, function(e) {
            var that = this;
            shareTimeOut = window.setTimeout(function(){
                $(that).find('.shared-items').hide();
            },100);

        });
    }
    /!**
     * 获取分享主链接
     *!/
    function gcShare(cmd,options){
        var shareUrl = '';
        switch(cmd){
            case 'tsina':
                shareUrl = 'http://service.weibo.com/share/share.php?';
                shareUrl += 'url='+encodeURIComponent(options.url)+'&title='+encodeURIComponent(options.title)+'&pic='+encodeURIComponent(options.pic)+'&searchPic=false';
                break;
            case 'weixin':
                shareWeixin(options.url);
                return false;
                break;
            case 'qzone':
                shareUrl = 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?';
                shareUrl += 'url='+encodeURIComponent(options.url)+'&title='+encodeURIComponent(options.title)+'&pics='+encodeURIComponent(options.pic)+'&summary='+encodeURIComponent(options.content);
                break;
            default:
                break;
        }
        window.open(shareUrl);
    }
    //首页分享
    $('body').on('click', '.shared-box .shared-items .shared-tips a', function(e) {
        //removeCssLink('share');
        var id = $(this).closest('.shared-box').attr('data-id');
        var data_cmd = $(this).attr('data-cmd');
        var opTools = $(this).closest('.op-tools');
        var mainContent = opTools.prev();
        var title = mainContent.find('h4').text();
        var url = 'http://' + document.domain+mainContent.find('h4>a').attr('href');
        var summary = mainContent.find('.item-content').text();
        var pic = mainContent.find('.item-pic img');
        if(pic.length==0){
            pic = '';
        }else{
            pic = pic.attr('src');
        }
        var share_url;
        var options = {
            url:'http://' + document.domain+'/main/content?id='+id,
            title: title,
            content: summary,
            pic: pic,
        };
        gcShare(data_cmd,options);
    });

    /!**
     * 微信分享
     *!/
    function shareWeixin(url){
        //弹窗
        var str = '';
        str += '<div class="gcshare-win-weixin">';
        str += '	<div class="gcshare-weixin-header">';
        str += '		<span>分享到微信朋友圈</span>';
        str += '		<a href="javascript:;" class="gcshare-close">×</a>';
        str += '	</div>';
        str += '	<div class="gcshare-weixin-body">';
        str += '		<div id="gcshareQrcode"></div>';
        str += '	</div>';
        str += '	<div class="gcshare-weixin-footer">';
        str += '		打开微信，点击底部的“发现”，<br>使用“扫一扫”即可将网页分享至朋友圈。';
        str += '	</div>';
        str += '</div>';

        //是否加载二维码工具
        if($('#scQrcode').length == 0){
            $('head').append('<script id="scQrcode" src="//user.guancha.cn/static/js/jquery.qrcode.min.js"></script>');
        }

        if($('.gcshare-win-weixin').length==0){
            $('body').append(str);
        }

        $(document).on('click','.gcshare-close',function(){
            $('.gcshare-win-weixin').remove();
        });

        if(typeof($('#gcshareQrcode').qrcode) == 'undefined'){
            var timer1 = setInterval(function(){
                if(typeof($('#gcshareQrcode').qrcode) != 'undefined'){
                    $('#gcshareQrcode').qrcode({
                        render: "canvas",
                        width: 200,
                        height: 200,
                        text: url
                    });
                    window.clearTimeout(timer1);
                }
            },100);
        }else{
            $('#gcshareQrcode').qrcode({
                render: "canvas",
                width: 200,
                height: 200,
                text: url
            });
        }
    }

    shareLayOut('.op-tools li.shared-box');


    //主贴分享
    $('.share-box .share-button > a').click(function() {
        var data_cmd = $(this).attr('data-cmd');
        text = $('.article-txt').text();
        if (text.length > 120) {
            text = $('.article-txt').text().substr(0, 120) + '...';
        }

        var options = {
            url:window.location.href,
            title: $('body h1').text(),
            content: text,
            pic: '',
        };
        gcShare(data_cmd,options);
    });

    //评论分享
    $('body').on('click', '.shared-comment .shared-items .shared-tips a', function(e) {
        //removeCssLink('share');
        var id = $(this).closest('.shared-comment').attr('data-id');
        var data_cmd = $(this).attr('data-cmd');
        var share_url;
        var content =$(this).closest('.cmt-item').children('.comment-txt').text();//内容

        var options = {
            url:window.location.href,
            title: content,
            content: $('title').text(),
            pic: '',
        };
        gcShare(data_cmd,options);
    });
    shareLayOut('.shared-comment');

    //关注话题
    $('.main-tow').on('click', '.follow', function() {
        var that = this;
        var id = $(this).attr('data-id');
        mylib.sendPostAjax('/topic/follow', { topic_id: id }, function(res) {
            if (res.code == 0) {
                if (res.data.action == 'set') {
                    $(that).html('已关注');
                    //$(that).unbind('click');
                    //$(that).removeAttr("href");
                    //$(that).removeAttr("data-id");
                } else if (res.data.action == 'cancel') {
                    $(that).html('<i></i>关注');
                }
            }
        });
        return false;
    });

    //推荐好友下面的关注
    $('.main-tow').on('click', '.recomment-friends-box .pay-attention', function() {
        var id = $(this).attr('data-id');
        var that = this;
        mylib.sendPostAjax('/user/attention', { to_user_id: id }, function(res) {

            if (res.code == 0) {
                if (res.data.action == 'set') {
                    $(that).html('已关注');
                } else if (res.data.action == 'cancel') {
                    $(that).html('<i></i>关注');
                }
            }
        });
        return false;
    });


    //增加一个返回顶部功能
    function addGoBack() {
        var goBack = $('<div class="go-back"></div>');
        var wrapper = $('.wrapper');
        if(wrapper.length == 0) return;
        var offset = wrapper.offset();
        var width = wrapper.width();
        var left = offset.left;

        goBack.css({

            'float': 'left',
            'position': 'fixed',
            'left': left + width + 18,
            'bottom': 50,
            'width': 38,
            'height': 38,
            'cursor': 'pointer',

        });
        goBack.click(function(event) {
            $(window).scrollTop(0);
        });
        goBack.hide();
        goBack.appendTo('.wrapper');
        var isShow = false;
        $(window).scroll(function() {
            if ($(window).scrollTop() > 300) {
                if (!isShow) {
                    goBack.show();
                    isShow = true;
                }
            } else {
                if (isShow) {
                    goBack.hide();
                    isShow = false;
                }

            }
        });
    }
    //搜索模块
    (function(){
        $('.search-input').find('input').focus(function(event){
            $('.search-layout').show();
        });
        $('.search-input').click(function(event){
            event.stopPropagation();
        });
        var searchHistoryData = mylib.getCookie('search-history');
        if(searchHistoryData == null){
            searchHistory = [];
        }else{
            searchHistory = JSON.parse(searchHistoryData);
            //从cookie中提取出关键字插入到搜索下拉列表中
            var str = '';
            for( var i=0; i<searchHistory.length; i++){
                str+= '<li data-keyword="'+searchHistory[i]+'">'+searchHistory[i]+'<span class="del">x</span></li>';
            }
            $('.history-search-list').append(str);
            //添加删除事件
            $('.history-search-list').find('.del').click(function(){
                var keyword = $(this).parent().data('keyword');
                for( var i=0; i<searchHistory.length; i++){
                    if(searchHistory[i] == keyword){
                        console.log(i);
                        searchHistory.splice(i, 1);
                        break;
                    }
                }
                //写会cookie
                searchHistoryData = JSON.stringify(searchHistory);
                mylib.setCookie('search-history', searchHistoryData);
                $(this).parent().remove();
                //console.log('执行了删除');
                return false;
            });
        }

        //鼠标划过
        $('.search-layout').find('li').mouseover(function(){
            $('.search-layout').find('li').removeClass('active');
            $(this).addClass('active');
        });

        //点击关键词开始搜索
        $('.search-layout').find('li').click(function(){
            var keyword = $(this).data('keyword');
            $('.search-input').find('input').val(keyword);

            $('.search-input').find('a').click();
            $('.search-layout').hide();
            //console.log('执行了点击');
            return false;
        });
        //点击搜索栏里面的放大镜进行搜索
        $('.search-input').find('a').click(function(){
            var url = '/main/search';
            var keyword= $(this).prev('input').val();
            if($.trim(keyword) != ''){
                //将关键词记录进cookie

                if($.isArray(searchHistory)){
                    if(searchHistory.indexOf(keyword) == -1){
                        //console.log('aaa');
                        searchHistory.unshift(keyword);
                        if(searchHistory.length >5){
                            searchHistory.pop();
                        }
                    }else{
                        //删除在头部重新添加
                        searchHistory.splice(searchHistory.indexOf(keyword), 1);
                        searchHistory.unshift(keyword);
                    }
                    searchHistoryData = JSON.stringify(searchHistory);
                    mylib.setCookie('search-history', searchHistoryData);
                }
                keyword = encodeURIComponent(keyword);
                if(typeof click != 'undefined'){
                    window.location.href = url + '?click='+ click + '&keyword='+keyword;
                }else{
                    window.location.href = url + '?keyword='+keyword;
                }

            }else{
                mylib.msg('搜索内容不能为空');
            }

        });
        //按回车提交搜索
        $(document).keydown(function (e) {
            if (e.which === 13) {
                var searchInput = $('.search-input').find('input');
                var val = searchInput.val();
                if(searchInput.is(':focus') && $.trim(val) != ''){
                    $('.search-input').find('a').click();
                    return false;
                }
            }
        });
    })();

    //按ESC关闭提出框
    $(document).keydown(function (e) {
        if (e.which === 27) {
            mylib.closePopup();
        }
    });
    //全部专栏加载全部
    $('.load-all').click(function(){
        var that = this;
        $.ajax({
            url: '/user/load-all-remain-big-view',
            type: 'get',
            dataType: 'html',
            success : function(res){
                $('.remian-big-view').closest('.panel-box').remove();
                $('.box-right').append(res);
                $('.load-all').remove();
            },
        });
    });
    /!*加载用户信息*!/
    function loadUser(){
        var _user = mylib.getUserDataByCookie();
        var userUrl = mylib.getUserUrl();
        if(_user){
            var _name = decodeURI(_user[1]);//用户名

            _name = _name.substr(0, 5);
            var _userId = _user[0];
            var _userImg=mylib.getUrl('user')+'/static/imgs/default_user_pic.png';//用户头像
            var redirectUrl = encodeURIComponent(window.location.href);
            //根据域名判断
            if($(".header-content").length>0){
                var _userNav='<div class="header-nav"><div class="user-nav">';
                _userNav+='<ul class="login-state">';
                _userNav+='<li class="message" id="sixin"><label></label><a href="'+userUrl+'/user/all-message" target="_blank">私信</a></li>';
                _userNav+='<li class="notice" id="tixing"><label></label><a href="'+userUrl+'/user/notice" target="_blank">提醒</a></li>';
                _userNav+='<li class="avatar"><a href="#"><img src="'+_userImg+'"></a><label class="triangle_down_gray"></label></li>';
                _userNav+='</ul>';
                _userNav+='<ul class="drop-down-list">';
                _userNav+='<li class="menu"><a href="'+userUrl+'/user/personal-homepage?uid='+_userId+'" target="_blank"><label class="iconfont icon-geren"></label><span>个人主页</span></a></li>';
                _userNav+='<li class="line"></li><li class="menu"><a href="'+userUrl+'/user/personal-homepage?uid='+_userId+'&amp;click=my-article"><label class="iconfont icon-wenzhang"></label><span>我的文章</span></a></li>';
                _userNav+='<li class="line"></li><li class="menu"><a href="'+userUrl+'/user/user-setting"><label class="iconfont icon-shezhi"></label><span>账号设置</span></a></li>';
                _userNav+='<li class="line"></li><li class="menu"><a href="'+userUrl+'/main/logout?redirectUrl="'+redirectUrl+'"><label class="iconfont icon-tuichu"></label><span>退出</span></a></li>';
                _userNav+='<li class="arrows"></li>';
                _userNav+='</ul></div></div>';
                $(".header-content").append('<div style="display:inline-block;float:right;height:65px;">'+_userNav+'</div>');

                //加载通知数 私信数 和用户头像
                $.ajax({
                    url: userUrl+'/user/get-user-tips',
                    type: 'GET',
                    dataType: 'jsonp',
                    data: {},
                    success : function(res){
                        if(res.code == 0){
                            if (res.xiaoxi > 0) {      //通知
                                $('.user-nav #tixing').append($('<span class="tip">'+res.xiaoxi+'</span>'));
                            }
                            if (res.sixin > 0) {       //私信
                                $('.user-nav #sixin').append($('<span class="tip">'+res.sixin+'</span>'));
                            }
                            $('.user-nav .avatar').find('img').attr('src', res.avatar);
                        }
                    }
                });
            }else if($(".header-index-right").length>0){
                var _userNav='<div class="header-nav"><div class="user-nav">';
                _userNav+='<ul class="login-state">';
                _userNav+='<li class="message" id="sixin"><label></label><a href="'+userUrl+'/user/all-message" target="_blank">私信</a></li>';
                _userNav+='<li class="notice" id="tixing"><label></label><a href="'+userUrl+'/user/notice" target="_blank">提醒</a></li>';
                _userNav+='<li class="avatar"><a href="#"><img src="'+_userImg+'"></a><label class="triangle_down_gray"></label></li>';
                _userNav+='</ul>';
                _userNav+='<ul class="drop-down-list">';
                _userNav+='<li class="menu"><a href="'+userUrl+'/user/personal-homepage?uid='+_userId+'" target="_blank"><label class="iconfont icon-geren"></label><span>个人主页</span></a></li>';
                _userNav+='<li class="line"></li><li class="menu"><a href="'+userUrl+'/user/personal-homepage?uid='+_userId+'&amp;click=my-article"><label class="iconfont icon-wenzhang"></label><span>我的文章</span></a></li>';
                _userNav+='<li class="line"></li><li class="menu"><a href="'+userUrl+'/user/user-setting"><label class="iconfont icon-shezhi"></label><span>账号设置</span></a></li>';
                _userNav+='<li class="line"></li><li class="menu"><a href="'+userUrl+'/main/logout?redirectUrl="'+redirectUrl+'"><label class="iconfont icon-tuichu"></label><span>退出</span></a></li>';
                _userNav+='<li class="arrows"></li>';
                _userNav+='</ul></div></div>';
                $(".header-index-right").append('<div style="display:inline-block;float:right;height:46px;">'+_userNav+'</div>');

                //加载通知数 私信数 和用户头像
                $.ajax({
                    url: userUrl+'/user/get-user-tips',
                    type: 'GET',
                    dataType: 'jsonp',
                    data: {},
                    success : function(res){
                        if(res.code == 0){
                            if (res.xiaoxi > 0) {      //通知
                                $('.user-nav #tixing').append($('<span class="tip">'+res.xiaoxi+'</span>'));
                            }
                            if (res.sixin > 0) {       //私信
                                $('.user-nav #sixin').append($('<span class="tip">'+res.sixin+'</span>'));
                            }
                            $('.user-nav .avatar').find('img').attr('src', res.avatar);
                        }
                    }
                });
            }else{
                var _userNav='<div class="header-login-yet">';
                _userNav+=' <a id="sixin" href="'+userUrl+'/user/all-message" target="_blank">私信</a>';
                _userNav+=' <a id="xiaoxi" href="'+userUrl+'/user/notice" target="_blank">提醒</a>';
                _userNav+=' <div class="header-user j-header-user">';
                _userNav+='     <img src="'+_userImg+'" alt="头像">';
                _userNav+='     <span>'+_name+'</span>';
                _userNav+='     <em></em>';
                _userNav+='     <ul class="set-menu j-set-menu">';
                _userNav+='         <li class="set-menu-1"><a href="'+userUrl+'/user/personal-homepage?uid='+_userId+'" target="_blank"><i></i><span>我的主页</span></a></li>';
                _userNav+='         <li class="set-menu-4"><a href="'+userUrl+'/user/personal-homepage?uid='+_userId+'&amp;click=my-article" target="_blank"><i></i><span>我的文章</span></a></li>';
                _userNav+='         <li class="set-menu-2"><a href="'+userUrl+'/user/user-setting" target="_blank"><i></i><span>设置</span></a></li>';
                _userNav+='         <li class="set-menu-3"><a href="'+userUrl+'/main/logout?redirectUrl="'+redirectUrl+'"><i></i><span>退出</span></a></li>';
                _userNav+='     </ul>';
                _userNav+=' </div>';
                _userNav+='</div>';
                $(".header .header-right").html(_userNav);

                //加载通知数 私信数 和用户头像
                $.ajax({
                    url: userUrl+'/user/get-user-tips',
                    type: 'GET',
                    dataType: 'jsonp',
                    data: {},
                    success : function(res){
                        if(res.code == 0){
                            if (res.xiaoxi > 0) {      //通知
                                $('.header-login-yet > #xiaoxi').html('提醒<i class="warm-spots"></i>');
                            }
                            if (res.sixin > 0) {       //私信
                                $('.header-login-yet > #sixin').html('私信<i class="warm-spots"></i>');
                            }
                            $('.header-user > img').attr('src', res.avatar);
                        }
                    }
                });
            }
        }else{
            if($(".header-content").length>0){
                var _nav = '<div style="display:inline-block;float:right;height:65px;"><span class="login-image"></span><a class="popup-login" style="display:inline-block;line-height:65px;font-size:17px;" href="javascript:;">登录</a>&nbsp;/&nbsp;<a class="popup-register" style="display:inline-block;line-height:65px;font-size:17px;" href="javascript:;">注册</a></div>';
                $(".header-content").append(_nav);
            }else if($(".header-index-right").length>0){
                var _nav = '<div class="header-index-login"><a class="j-log popup-login" href="javascript:;">登录</a>&nbsp;&nbsp;<a class="j-log-r popup-register" href="javascript:;">注册</a></div>';
                $(".header-index-right").html(_nav);
            }else{
                var _nav = '<div class="header-login-no"><a class="j-log popup-login" href="javascript:;">登录</a>&nbsp;&nbsp;<a class="j-log-r popup-register" href="javascript:;">注册</a></div>';
                $(".header .header-right").html(_nav);
            }
        }
    }

    var temp = document.domain.split(".");
    var hostName = temp[0];
    if(hostName == 'www'){
        loadUser();
        $('.drop-down-list').hide();
        var $headUser = $('.j-header-user'),
            $setMenu = $('.j-set-menu');
        $headUser.hover(function() {
            $setMenu.show();
        }, function() {
            $setMenu.hide();
        });

        var now = new Date(); var year = now.getFullYear(); var month = now.getMonth(); var date = now.getDate(); var day = now.getDay(); var week;
        month = month + 1; if (month < 10) month = "0" + month; if (date < 10) date = "0" + date;
        var arr_week = new Array("星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六");
        week = arr_week[day]; var time = ""; time = year + "-" + month + "-" + date;
        $('#date').html(week+'&nbsp;'+time);
        $('body').find('.user-nav').on('click', '.avatar', function(ev) {
            layOutHide();
            $('.drop-down-list').toggle();
            return false;
        });

        $('body').on('click', '.other-box a.collect', function(event){
            var _user = mylib.getUserDataByCookie();
            if(!_user){
                mylib.login(function() {
                    window.location.reload(true);
                });//弹出登录框
                return;
            }else{
                $.ajax({
                    url: mylib.getUserUrl() +'/post/collect',
                    type: 'GET',
                    dataType: 'jsonp',
                    data: { 'codeId': _DOC_ID, 'codeType': 1, 'from' : 2},
                    success : function function_name(res) {
                        if(res.code == 203){
                            isLogin = false;
                            mylib.checkLogin();
                            return;
                        }else if (res.code == 0) {
                            if(res.data.action=='set'){
                                $('#count0').text(parseInt($('#count0').text())+1);
                            }else if(res.data.action=='cancel'&&$('#count0').text()!=0){
                                $('#count0').text(parseInt($('#count0').text())-1);
                            }
                        }
                    }
                });
            }
        });
        //首页滚动关注
        $('body').on('click','.fastNews-attend', function(event){
            var _user = mylib.getUserDataByCookie();
            that = $(this);
            if(!_user){
                mylib.login(function() {
                    window.location.reload(true);
                });//弹出登录框
                return;
            }else{
                to_uid = $(this).parent().attr('to-uid');
                $('li[to-uid='+to_uid+']').find('.fastNews-attend').text('已关注').attr('attended','done');
                $('.fastNews-attend').removeClass('fastNews-attend').addClass('fastNews-attend-attended');
                exist = '';
                $('.fastNews-guanzhu li').each(function(){
                    if(exist=='') exist = $(this).attr('to-uid');
                    else exist+= ','+$(this).attr('to-uid');
                })
                $.ajax({
                    url: mylib.getUserUrl() +'/user/attention-cms',
                    type: 'POST',
                    dataType: 'json',
                    xhrFields: {
                        withCredentials: true
                    },
                    data: { 'to_user_id': to_uid ,'exist': exist},
                    success : function function_name(res) {
                        if(res.code == 203){
                            isLogin = false;
                            mylib.checkLogin();
                            return;
                        }else if (res.code == 0) {
                            if(res.info.user_photo=="/static/imgs/default_user_pic.png")
                                item='<li to-uid="'+res.info.id+'" style="display:none"><a style="float:left" href="//user.guancha.cn/user/personal-homepage?uid='+res.info.id+'" target="_blank"><img src="https://user.guancha.cn/static/imgs/default_user_pic.png"></a>';
                            else
                                item='<li to-uid="'+res.info.id+'" style="display:none"><a style="float:left" href="//user.guancha.cn/user/personal-homepage?uid='+res.info.id+'" target="_blank"><img src="'+res.info.user_photo+'?imageMogr2/cut/574x480x29x24"></a>';
                            item+='<div class="fastNews-user"><span class="fastNews-name"><a style="float:left" href="//user.guancha.cn/user/personal-homepage?uid='+res.info.id+'" target="_blank">'+res.info.user_nick+'</a></span>';
                            if(res.info.user_description!=null) item+='<span class="fastNews-desc">'+res.info.user_description+'</span>';
                            item+='</div>';
                            item+='<div class="fastNews-attend"><span>+</span>关注</div>';
                            item+='</li>';
                            $attendPos = $('li[to-uid='+to_uid+']').parent();
                            that.parents('.fastNews-guanzhu').find('li').children().slideUp("fast",function(){
                                $('.fastNews-attend-attended').each(function(){
                                    if($(this).attr('attended')!='done') $(this).removeClass('fastNews-attend-attended').addClass('fastNews-attend');
                                })
                                $('li[to-uid='+to_uid+']').remove();
                                $attendPos.html(item);
                                $('li[to-uid='+res.info.id+']').fadeIn();
                            })
                        }else{
                            $('.fastNews-attend-attended').each(function(){
                                if($(this).attr('attended')!='done') $(this).removeClass('fastNews-attend-attended').addClass('fastNews-attend');
                            })
                        }
                    }
                });
            }
        });
        $('body').on('click', '.module-fengwen-comment-hot a.praise', function(event){
            var _user = mylib.getUserDataByCookie();
            if(!_user){
                mylib.login(function() {
                    window.location.reload(true);
                });//弹出登录框
                return;
            }else{
                var commenthot = $('body').find('.module-fengwen-comment-hot').eq(0).attr("cid");
                $.ajax({
                    url: mylib.getUserUrl() +'/comment/praise',
                    type: 'POST',
                    dataType: 'json',
                    xhrFields: {
                        withCredentials: true
                    },
                    data: { 'id': commenthot, 'from' : 1},
                    success : function function_name(res) {
                        if(res.code == 203){
                            isLogin = false;
                            mylib.checkLogin();
                            return;
                        }else if (res.code == 0) {
                            if(res.type){
                                $('body').find('.praise span').eq(0).text(parseInt($('body').find('.praise span').eq(0).text())+1);
                            }else{
                                if((parseInt($('body').find('.praise span').eq(0).text())-1)<0) $('body').find('.praise span').eq(0).text(0);
                                else $('body').find('.praise span').eq(0).text(parseInt($('body').find('.praise span').eq(0).text())-1)
                            }
                        }
                    }
                });
            }
        });
        var layOut;

        $('.header-login-yet').on('click', '#xiaoxi', function(event) {
            var that = this;
            if (!hasClickNotice) {
                $.ajax({
                    url: mylib.getUserUrl() +'/resource/get-notice',
                    type: 'POST',
                    dataType: 'html',
                    xhrFields: {
                        withCredentials: true
                    },
                    data: {},
                    success: function(res) {
                        var str = res;
                        layOutHide();
                        $('#xiaoxi').append(res);
                        hasClickNotice = true;
                    }
                });
            } else {
                layOutHide();
                hasClickNotice = false;
            }


            return false;
        });
        $('.header-login-yet').on('click', '.notice-box', function(event) {
            event.stopPropagation();
        });
        //点击其他地方关闭下拉框
        $(document).click(function(ev) {
            //$('.notice-box').hide();
            layOutHide();
            hasClickNotice = false;

        });
        //点击一条提醒 后去掉提醒框
        $('#xiaoxi').on('click', '.notice-item', function() {
            $(this).closest('.notice-box').remove();
            hasClickNotice = false;
        });
        //点击清除全部通知按钮
        $('.header-login-yet').on('click', '.clear-all-notice', function(event) {
            var that = this;
            $.ajax({
                url: mylib.getUserUrl() +'/user/clear-all-notice',
                type: 'POST',
                dataType: 'json',
                xhrFields: {
                    withCredentials: true
                },
                data: {},
                success: function(res) {
                    if(res.code == 0){
                        //清空列表
                        $(that).closest('.notice-box').find('li').remove();
                        $('#xiaoxi').find('.tip').remove();
                    }
                }
            });
            return false;
        });

        $('.user-nav').on('click', '.notice', function(event) {
            var that = this;
            if (!hasClickNotice) {
                $.ajax({
                    url: mylib.getUserUrl() +'/resource/get-notice',
                    type: 'POST',
                    dataType: 'html',
                    xhrFields: {
                        withCredentials: true
                    },
                    data: {},
                    success: function(res) {
                        var str = res;
                        layOutHide();
                        $('.notice').append(res);
                        hasClickNotice = true;
                    }
                });
            } else {
                layOutHide();
                hasClickNotice = false;
            }


            return false;
        });
        $('.user-nav').on('click', '.notice-box', function(event) {
            event.stopPropagation();
        });
        //点击一条提醒 后去掉提醒框
        $('.notice').on('click', '.notice-item', function() {
            $(this).closest('.notice-box').remove();
            hasClickNotice = false;
        });
        //点击清除全部通知按钮
        $('.user-nav').on('click', '.clear-all-notice', function(event) {
            var that = this;
            $.ajax({
                url: mylib.getUserUrl() +'/user/clear-all-notice',
                type: 'POST',
                dataType: 'json',
                xhrFields: {
                    withCredentials: true
                },
                data: {},
                success: function(res) {
                    if(res.code == 0){
                        //清空列表
                        $(that).closest('.notice-box').find('li').remove();
                        $('.notice').find('.tip').remove();
                    }
                }
            });
            return false;
        });

        //点击空白处 关闭举报
        // $(document).click(function(event) {
        //     if(layOut) layer.close(layOut);
        // });

    }else if(hostName == 'm'){
        $('body').on('click', 'a.collect', function(event){
            var _user = mylib.getUserDataByCookie();
            if(!_user){
                mylib.login(function() {
                    window.location.reload(true);
                });//弹出登录框
                return;
            }else{
                $.ajax({
                    url: 'http://user.guancha.cn/post/collect',
                    type: 'GET',
                    dataType: 'jsonp',
                    data: { 'codeId': _DOC_ID, 'codeType': 1, 'from' : 2},
                    success : function function_name(res) {
                        if(res.code == 203){
                            isLogin = false;
                            mylib.checkLogin();
                            return;
                        }else if (res.code == 0) {
                            if(res.data.action=='set'){
                                alert('收藏成功！');
                            }else if(res.data.action=='cancel'&&$('#count0').text()!=0){
                                alert('已取消收藏');
                            }
                        }
                    }
                });
            }
        });
    }else if(hostName == 'user'){
        var _user = mylib.getUserDataByCookie();
        var userUrl = mylib.getUserUrl();
        if(_user){
            var _name = decodeURI(_user[1]);//用户名

            _name = _name.substr(0, 5);
            var _userId = _user[0];
            var redirectUrl = encodeURIComponent(window.location.href);

            $('.user-nav .personal-url').attr('href','/user/personal-homepage?uid='+_userId);
            $('.user-nav .my-article').attr('href','/user/personal-homepage?uid='+_userId+'&click=my-article');

            $('.login-state').show();

            $.ajax({
                url: userUrl+'/user/get-user-tips',
                type: 'GET',
                dataType: 'jsonp',
                success : function(res){
                    if(res.code != 0) return false;

                    if(res.sixin > 0){
                        $('.login-state>li.message').append('<span class="tip">'+res.sixin+'</span>');
                    }

                    if(res.xiaoxi > 0){
                        $('.login-state>li.notice').append('<span class="tip">'+(res.xiaoxi<=99 ? res.xiaoxi : '99+')+'</span>');
                    }

                    $('.login-state>li.avatar img').attr('src', res.avatar);
                },
            });

        }else{
            $('.un-login-state').show();
        }
    }


})();*/
