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
        /!** ��������������� *!/
        sharedBoxIndex: false,
        noticeBoxIndex: false, // ֪ͨ������
        //���ڼ���״̬
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
         * ���ֲ� isOpen �Ƿ�򿪣�trueΪ�򿪣�falseΪ�ر�
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
         * ��ʾ������Ϣ
         *!/
        showError: function(input, msg) {
            var label = input.next('label.login-error');
            label.html(msg);
            if (!label.hasClass('visibility')) {
                label.addClass('visibility');
            }
        },
        /!**
         * ��λԪ���������Ļ����
         *!/
        positionCenter: function(obj, width, height) {
            //���㶨λ
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
         * �رյ���
         *!/
        closePopup: function() {
            var popup = $('.guancha-popup');
            if (popup.length > 0) popup.remove();
            mylib.shade(false);
        },
        /!**
         * �򿪵��㣬ֻ����һ��һ������ĳ���
         * data �ַ�����֧��html,
         *!/
        openPopup: function(data) {
            mylib.shade(true);
            var popup = $('.guancha-popup');
            if (popup.length > 0) popup.remove();

            popup = $('<div class="guancha-popup"></div>');

            var close = $('<a href="javascript:;" class="popup-box-close"></a>'); //�رհ�ť
            popup.append(close); //�رհ�ť
            close.click(function() {
                mylib.closePopup();
                return false;
            });

            popup.append(data);
            $('body').append(popup);

            //���㶨λ
            var popupWidth = popup.innerWidth();
            var popupHeight = popup.innerHeight();
            mylib.positionCenter(popup, popupWidth, popupHeight); //��λpopup
            popup.show();

            //���ڴ�С�ı�ʱ���¼���popup��λ��
            $(window).resize(function() {
                mylib.positionCenter(popup, popupWidth, popupHeight); //��λpopup
            });
        },
        /!**
         * �Զ���confrim������
         * info��ʾѡ��
         * cancleTip ȡ����ʾ
         * doTip ȷ�ϰ�ť
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

            //���㶨λ
            var cwidth = confirmModule.outerWidth();
            var cheight = confirmModule.outerHeight();
            mylib.positionCenter(confirmModule, 241, cheight); //��λpopup
            //confirmModule.show();

            //���ڴ�С�ı�ʱ���¼���popup��λ��
            $(window).resize(function() {
                mylib.positionCenter(confirmModule, 241, cheight); //��λpopup
            });
        },
        /!**
         * �ر�confirm������
         *!/
        closeConfirm : function(){
            $('.confirm-module').remove();

        },
        /!**
         * ��Ϣ��ʾ��
         * @param  {[type]} data [��ʾ����]
         * @param  {[type]} time [��ʧʱ�� ����Ϊ��λ]
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

            //���㶨λ
            var popupWidth = popup.innerWidth();
            var popupHeight = popup.innerHeight();
            mylib.positionCenter(popup, popupWidth, popupHeight); //��λpopup
            popup.show();

            //���ڴ�С�ı�ʱ���¼���popup��λ��
            $(window).resize(function() {
                mylib.positionCenter(popup, popupWidth, popupHeight); //��λpopup
            });
            if (typeof time == 'undefined') {
                time = 2;
            }
            window.setTimeout(function() {
                popup.hide();
            }, time * 1000);
        },
        /!**
         * ��֤��
         * input �ı�����Σ�type����,mobile,password
         *!/
        validateInput: function(input, type) {
            switch (type) {
                case 'usernick':
                    var str = input.val();
                    if (!(/^[\u4e00-\u9fa5_a-zA-Z0-9��]+$/.test(str))) {
                        mylib.showError(input, 'ֻ�ܺ��к��֡���ĸ�������»���');
                        return false;
                    }
                    len = str.length;
                    if (len > 20 || len < 2) {
                        mylib.showError(input, '�ǳƳ���2-20���ַ�');
                        return false;
                    }
                    return true;
                case 'mobile':
                    if (!(/^1[3456789]{1}\d{9}$/.test($.trim(input.val())))) {
                        mylib.showError(input, '��������ȷ���ֻ�����');
                        return false;
                    }
                    return true;
                case 'password':
                    var len = input.val().length;
                    if (len > 18 || len < 6) {
                        mylib.showError(input, '���볤��6-18λ');
                        return false;
                    }
                    return true;
                case 'captcha':
                    if (!(/^\S{4}$/.test(input.val()))) {
                        input.next().next('img').hide();
                        input.next().next('a').hide();
                        mylib.showError(input, '��֤�����');
                        return false;
                    }
                    return true;
                default:
                    return false;
            }
        },
        //�����ֻ��� ��
        validateMobileInput : function(input, code){
            if(code == '86'){
                if (!(/^1[3456789]{1}\d{9}$/.test($.trim(input.val())))) {
                    mylib.showError(input, '��������ȷ���ֻ�����');
                    return false;
                }
            }else{
                if($.trim(input.val()) == ''){
                    mylib.showError(input, '��������ȷ���ֻ�����');
                    return false;
                }
            }
            return true;
        },
        bindPhoneCodeList : function(){
            //�����������
            var prefix = '+';

            var commonArea = {
                "�й�":"86",
                "�й�̨��": "886",
                "�й����": "852",
                "�й�����": "853",
                "����":"1",
                "����˹":"7",
                "���ô�":"1",
                "�Ĵ�����":"61",
                "�ձ�":"81",
                "�¼���":"65",
                "Ӣ��":"44",
                "�¹�":"49",
                "��������":"60",
                "������":"64",
                "����":"82",
                "����":"33",
                "̩��":"66",
                "Խ��":"84",
                "�����":"39",
                "���ɱ�":"63",
                "����":"31",
                "ӡ��������":"62",
                "����կ":"855",
                "������":"34",
                "���":"46",
                "��ʿ":"41",
            };
            var area = {"������":"244","������":"93","����������":"355","����������":"213","���������͹�":"376","��������":"1264","����ϺͰͲ���":"1268","����͢":"54","��������":"374","��ɭ��":"247","�Ĵ�����":"61","�µ���":"43","�����ݽ�":"994","�͹���":"1242","����":"973","�ϼ�����":"880","�ͰͶ�˹":"1246","�׶���˹":"375","����ʱ":"32","������":"501","����":"229","��Ľ��Ⱥ��":"1441","����ά��":"591","��������":"267","����":"55","����":"673","��������":"359","�����ɷ���":"226","���":"95","��¡��":"257","����¡":"237","���ô�":"1","����Ⱥ��":"1345","�зǹ��͹�":"236","է��":"235","����":"56","�й�":"86","���ױ���":"57","�չ�":"242","���Ⱥ��":"682","��˹�����":"506","�Ű�":"53","����·˹":"357","�ݿ�":"420","����":"45","������":"253","������ӹ��͹�":"1890","��϶��":"593","����":"20","�����߶�":"503","��ɳ����":"372","���������":"251","쳼�":"679","����":"358","����":"33","����������":"594","����":"241","�Ա���":"220","��³����":"995","�¹�":"49","����":"233","ֱ������":"350","ϣ��":"30","�����ɴ�":"1809","�ص�":"1671","Σ������":"502","������":"224","������":"592","����":"509","�鶼��˹":"504","�й����":"852","������":"36","����":"354","ӡ��":"91","ӡ��������":"62","����":"98","������":"964","������":"353","��ɫ��":"972","�����":"39","���ص���":"225","�����":"1876","�ձ�":"81","Լ��":"962","����կ":"855","������˹̹":"327","������":"254","����":"82","������":"965","������˹̹":"331","����":"856","����ά��":"371","�����":"961","������":"266","��������":"231","������":"218","��֧��ʿ��":"423","������":"370","¬ɭ��":"352","�й�����":"853","����˹��":"261","����ά":"265","��������":"60","�������":"960","����":"223","�����":"356","��������Ⱥ��":"1670","�������":"596","ë����˹":"230","ī����":"52","Ħ������":"373","Ħ�ɸ�":"377","�ɹ�":"976","���������ص�":"1664","Ħ���":"212","Īɣ�ȿ�":"258","���ױ���":"264","�³":"674","�Ჴ��":"977","����������˹":"599","����":"31","������":"64","�������":"505","���ն�":"227","��������":"234","����":"850","Ų��":"47","����":"968","�ͻ�˹̹":"92","������":"507","�Ͳ����¼�����":"675","������":"595","��³":"51","���ɱ�":"63","����":"48","��������������":"689","������":"351","�������":"1787","������":"974","������":"262","��������":"40","����˹":"7","ʥ¬����":"1758","ʥ��ɭ�ص�":"1784","����Ħ��(��)":"684","����Ħ��":"685","ʥ����ŵ":"378","ʥ��������������":"239","ɳ�ذ�����":"966","���ڼӶ�":"221","�����":"248","��������":"232","�¼���":"65","˹�工��":"421","˹��������":"386","������Ⱥ��":"677","������":"252","�Ϸ�":"27","������":"34","˹������":"94","ʥ��ɭ��":"1784","�յ�":"249","������":"597","˹��ʿ��":"268","���":"46","��ʿ":"41","������":"963","�й�̨��":"886","������˹̹":"992","̹ɣ����":"255","̩��":"66","���":"228","����":"676","�������Ͷ�͸�":"1809","ͻ��˹":"216","������":"90","������˹̹":"993","�ڸɴ�":"256","�ڿ���":"380","����������������":"971","Ӣ��":"44","����":"1","������":"598","���ȱ��˹̹":"233","ί������":"58","Խ��":"84","Ҳ��":"967","��˹����":"381","��Ͳ�Τ":"263","������":"243","�ޱ���":"260"};
            var hasClick = false;

            $('.telephone-code').click(function(){
                var that = this;
                if(hasClick == false){
                    var list = '<ul class="telephone-code-list">';
                    list += '<ul class="inner-list">';
                    list += '<li style="font-size:16px; font-weight:bold; color : #333">���ù��һ����</li>';
                    for (var i in commonArea) {
                        var content = i + ' ' + prefix + commonArea[i];
                        list += '<li data-code="'+ commonArea[i] +'">'+ content +'</li>';
                    }
                    list += '</ul>';
                    list += '<ul class="inner-list">';
                    list += '<li style="font-size:16px; font-weight:bold; color : #333">���й��һ����</li>';
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
         * ע��
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
                    //�󶨽����¼�
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
                    //���ύ�¼�
                    form.submit(function() {
                        //��֤
                        var result = true;
                        var phoneCode = $('.telephone-code').find('.code').attr('data-code');

                        if (!lib.validateInput(form.find('#txtUserNick'), 'usernick')) result = false;
                        if (!lib.validateMobileInput(form.find('#txtMobile'), phoneCode)) result = false;
                        var pwd = form.find('#txtPassword');
                        var cpwd = form.find('#txtConfirmPassword');
                        lib.validateInput(pwd, 'password');
                        if (cpwd.val() != pwd.val()) {
                            lib.showError(cpwd, '���벻һ��');
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

                    //��ȡ��֤��
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
                            $("#txtPcCaptcha").next('.login-error').text('��������ͼƬ��֤��');
                            $("#txtPcCaptcha").next('.login-error').addClass('visibility');
                            check = false;
                        }else if (!mylib.validateInput($("#txtPcCaptcha"), 'captcha')) {
                            $("#txtPcCaptcha").next().next('img').click();
                            check = false;
                        }
                        if (check) {
                            //��ȡ��֤��
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
                                            mylib.msg('���ͳɹ�', 2 ,true);
                                            isSend = true;
                                            //���ͳɹ��󵹼�ʱ
                                            var countdown = 60;
                                            that.html(countdown + 's');
                                            window.clearInterval(time);
                                            time = setInterval(function() {
                                                if (countdown <= 0) {
                                                    that.html('��ȡ��֤��');
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
         * ��������
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
                    var close = popup.find('.close'); //�رհ�ť

                    close.click(function() {
                        popup.remove();
                        mylib.shade(false);
                        return false;
                    });


                    $('body').append(popup);

                    //���㶨λ
                    var popupWidth = popup.innerWidth();
                    var popupHeight = popup.innerHeight();
                    mylib.positionCenter(popup, popupWidth, popupHeight); //��λpopup
                    popup.show();

                    //���ڴ�С�ı�ʱ���¼���popup��λ��
                    $(window).resize(function() {
                        mylib.positionCenter(popup, popupWidth, popupHeight); //��λpopup
                    });
                    var form = $('#formReset');
                    //�󶨽����¼�
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
                    //���ύ�¼�
                    form.submit(function() {
                        //��֤
                        var result = true;

                        //if (!lib.validateInput(form.find('#txtMobile'), 'mobile')) result = false;
                        var phoneCode = $('.telephone-code').find('.code').attr('data-code');

                        if (!lib.validateMobileInput(form.find('#txtMobile'), phoneCode)) result = false;
                        var pwd = form.find('#txtPassword');
                        var cpwd = form.find('#txtConfirmPassword');
                        lib.validateInput(pwd, 'password');
                        if (cpwd.val() != pwd.val()) {
                            lib.showError(cpwd, '���벻һ��');
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
                                    lib.msg('���óɹ�');
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
                    //��ȡ��֤��
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
                            $("#txtPcCaptcha").next('.login-error').text('��������ͼƬ��֤��');
                            $("#txtPcCaptcha").next('.login-error').addClass('visibility');
                            check = false;
                        }else if (!mylib.validateInput($('#txtPcCaptcha'), 'captcha')) {
                            $("#txtPcCaptcha").next().next('img').click();
                            check = false;
                        }
                        if (check) {
                            //��ȡ��֤��
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
                                            mylib.msg('���ͳɹ�', 2 ,true);
                                            isSend = true;
                                            //���ͳɹ��󵹼�ʱ
                                            var countdown = 60;
                                            that.html(countdown + 's');
                                            window.clearInterval(time);

                                            time = setInterval(function() {
                                                if (countdown <= 0) {
                                                    that.html('��ȡ��֤��');
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
         * ��¼
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

                    //�󶨽����¼�
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
                    //�����������
                    form.find('.forget-pwd').click(function() {

                        mylib.resetPassword();
                    });
                    //���ύ�¼�
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
        //    if (url.indexOf("?") != -1) {		//����?��
        //       var str = url.substr(1);		//ȥ��?��
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
                } else { //û�� ����Ϊfalse
                    $(obj).html(action);
                }

                $(obj).removeClass('active');
            } else {
                number++;
                if (showNumer === true) {
                    //$(obj).html('ȡ��' + action + ' <span>' + number + '</span>');
                    $(obj).html(action + ' <span>' + number + '</span>');
                } else {
                    //$(obj).html('ȡ��' + action);
                    $(obj).html(action);
                }

                $(obj).addClass('active');
            }
        },
        collect: function(codeId, codeType, from, obj) { //�ղ�
            if (!mylib.checkLogin()) return;
            $.ajax({
                url: '/post/collect',
                type: 'GET',
                dataType: 'jsonp',
                data: { 'codeId': codeId, 'codeType': codeType, 'from' : from},
                success : function function_name(res) {
                    if (res.code == 0) {
                        mylib.interact('�ղ�', res.data.action, obj, true);
                    }
                }
            });
        },
        praise: function(postId, obj) { //��������

            this.sendPostAjax('/post/praise-and-tread', { 'actionType': 1, 'postId': postId }, function(res) {
                if (res.code == 0) {
                    mylib.interact('��', res.data.action, obj, true);
                }
            })

        },

        // praiseComment: function(commentId, obj) { //������

        //    this.sendPostAjax('/comment/praise', {'id': commentId }, function(res) {
        //        if (res.code == 0) {
        //            mylib.interact('��', res.data.action, obj, true);
        //        }
        //    })

        // },
        tread: function(postId, obj) { //������

            this.sendPostAjax('/post/praise-and-tread', { 'actionType': 2, 'postId': postId }, function(res) {
                if (res.code == 0) {
                    mylib.interact('��', res.data.action, obj, true);
                }
            })

        },
        treadComment: function(commentId, obj) { //������

            this.sendPostAjax('/comment/praise-and-tread', { 'actionType': 2, 'commentId': commentId }, function(res) {
                if (res.code == 0) {
                    mylib.interact('��', res.data.action, obj, true);
                }
            })

        },
        /!**
         * �ٱ�
         * @param  {[type]} accusationObj   [�ٱ����� accusation_post accusation_comment ]
         * @param  {[type]} accusationObjId [�ٱ�����id]
         * @param  {[type]} accusationType  [�ٱ�����]
         * @return {[type]}                 [description]
         *!/
        accusation: function(accusationObj, accusationObjId, accusationType, obj) {

        },
        //��ȡ������
        getRootDomain : function() {
            var temp = document.domain.split(".");
            return temp[temp.length - 2] + '.' + temp[temp.length - 1];

        },
        getUrl : function (key){
            //return  'http://'+key+'.'+ this.getRootDomain();
            return  '//'+key+'.'+ this.getRootDomain();
        },
        getUserDataByCookie:function(){
            //��COOKIE�л�ȡ�û���Ϣ������ֵΪNULL�����û�û��½
            var name = 'GCZWU';
            var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
            if(arr=document.cookie.match(reg)) {
                var user=arr[2].split("-");
                //�����û���Ϣ���ݣ�0Ϊ�û�ID��1Ϊ�û���
                return user;
            }
            else return false;
        },
        getUserUrl : function(){
            return this.getUrl('user');
        }


    };

    var initRes = mylib.init(); //��ʼ��

    //ע��
    $(document).on('click', '.popup-register', function() {
        mylib.register();

        return false;
    });

    //����
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

    //��¼
    $(document).on('click', '.popup-login', function() {
        mylib.login(function() {
            window.location.reload(true);
        });

        return false;
    });


    //���ͷ�񵯳�������
    $('.user-nav').on('click', '.avatar', function(ev) {
        layOutHide();
        $('.drop-down-list').toggle();
        return false;
    });


    //��������ֹð�ݡ���ֹ���������Ҳ��ر�
    $('.drop-down-list').click(function(ev) {
        ev.stopPropagation();
    })
    //��������ֹð�ݡ���ֹ�����������Ҳ��ر�
    // $('body').on('click', '.layui-layer', function(event) {
    //     event.stopPropagation();
    // });
    //��������ط��ر�������
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

        //����HTML
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
            userInteract.append('<div class="box"><span>����</span><span>' + res.post_count + '</span></div>');
            userInteract.append('<div class="line"></div>');
            userInteract.append('<div class="box"><span>����</span><span>' + res.comment_count + '</span></div>');
            userInteract.append('<div class="line"></div>');
            userInteract.append('<div class="box"><span>��˿</span><span>' + res.fans_count + '</span></div></div>');
            userInfo.append(userInteract);

            userTop.append(userInfo);
            popup.append(userTop);

            //bottom
            var user = mylib.getUserDataByCookie();
            var loginUid = user[0];
            if(loginUid != uid){        //��¼�û��͵����������û���ͬ��ʱ�� ����ʾfooter
                var footer = $('<div class="user-info-bottom clearfix"></div>');
                if (res.has_attention)
                    footer.append('<div class="attention">�ѹ�ע</div>');
                else {
                    var pay = $('<div class="attention pay-attention">��ע</div>');
                    pay.click(function() {

                        mylib.sendPostAjax(userUrl + '/user/attention', { to_user_id: uid }, function(res) {
                            if (res.code == 0) {
                                if (res.data.action == 'set') {
                                    pay.html('�ѹ�ע');
                                } else if (res.data.action == 'cancel') {
                                    pay.html('��ע');
                                }
                            }
                        });
                    });
                    footer.append(pay);
                }


                footer.append('<div class="line"></div>');
                footer.append('<div class="message"><a target="_blank" href="'+ userUrl +'/user/my-message?to_uid=' + uid + '">˽��</a></div>');

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
     * ��֪ͨ����
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
        //��������ط��ر�������
        $(document).click(function(ev) {
            //$('.notice-box').hide();
            layOutHide();
            hasClickNotice = false;

        });
        //���һ������ ��ȥ�����ѿ�
        $('.notice').on('click', '.notice-item', function() {
            $(this).closest('.notice-box').remove();
            hasClickNotice = false;
        });
        //������ȫ��֪ͨ��ť
        $('.user-nav').on('click', '.clear-all-notice', function(event) {
            var that = this;
            $.ajax({
                url: '/user/clear-all-notice',
                type: 'POST',
                dataType: 'json',
                data: {},
                success: function(res) {
                    if(res.code == 0){
                        //����б�
                        $(that).closest('.notice-box').find('li').remove();
                        $('.notice').find('.tip').remove();
                    }
                }
            });
            return false;
        });
    }
    //��֤��
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
     * ��ȡ����������
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
    //��ҳ����
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
     * ΢�ŷ���
     *!/
    function shareWeixin(url){
        //����
        var str = '';
        str += '<div class="gcshare-win-weixin">';
        str += '	<div class="gcshare-weixin-header">';
        str += '		<span>����΢������Ȧ</span>';
        str += '		<a href="javascript:;" class="gcshare-close">��</a>';
        str += '	</div>';
        str += '	<div class="gcshare-weixin-body">';
        str += '		<div id="gcshareQrcode"></div>';
        str += '	</div>';
        str += '	<div class="gcshare-weixin-footer">';
        str += '		��΢�ţ�����ײ��ġ����֡���<br>ʹ�á�ɨһɨ�����ɽ���ҳ����������Ȧ��';
        str += '	</div>';
        str += '</div>';

        //�Ƿ���ض�ά�빤��
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


    //��������
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

    //���۷���
    $('body').on('click', '.shared-comment .shared-items .shared-tips a', function(e) {
        //removeCssLink('share');
        var id = $(this).closest('.shared-comment').attr('data-id');
        var data_cmd = $(this).attr('data-cmd');
        var share_url;
        var content =$(this).closest('.cmt-item').children('.comment-txt').text();//����

        var options = {
            url:window.location.href,
            title: content,
            content: $('title').text(),
            pic: '',
        };
        gcShare(data_cmd,options);
    });
    shareLayOut('.shared-comment');

    //��ע����
    $('.main-tow').on('click', '.follow', function() {
        var that = this;
        var id = $(this).attr('data-id');
        mylib.sendPostAjax('/topic/follow', { topic_id: id }, function(res) {
            if (res.code == 0) {
                if (res.data.action == 'set') {
                    $(that).html('�ѹ�ע');
                    //$(that).unbind('click');
                    //$(that).removeAttr("href");
                    //$(that).removeAttr("data-id");
                } else if (res.data.action == 'cancel') {
                    $(that).html('<i></i>��ע');
                }
            }
        });
        return false;
    });

    //�Ƽ���������Ĺ�ע
    $('.main-tow').on('click', '.recomment-friends-box .pay-attention', function() {
        var id = $(this).attr('data-id');
        var that = this;
        mylib.sendPostAjax('/user/attention', { to_user_id: id }, function(res) {

            if (res.code == 0) {
                if (res.data.action == 'set') {
                    $(that).html('�ѹ�ע');
                } else if (res.data.action == 'cancel') {
                    $(that).html('<i></i>��ע');
                }
            }
        });
        return false;
    });


    //����һ�����ض�������
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
    //����ģ��
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
            //��cookie����ȡ���ؼ��ֲ��뵽���������б���
            var str = '';
            for( var i=0; i<searchHistory.length; i++){
                str+= '<li data-keyword="'+searchHistory[i]+'">'+searchHistory[i]+'<span class="del">x</span></li>';
            }
            $('.history-search-list').append(str);
            //���ɾ���¼�
            $('.history-search-list').find('.del').click(function(){
                var keyword = $(this).parent().data('keyword');
                for( var i=0; i<searchHistory.length; i++){
                    if(searchHistory[i] == keyword){
                        console.log(i);
                        searchHistory.splice(i, 1);
                        break;
                    }
                }
                //д��cookie
                searchHistoryData = JSON.stringify(searchHistory);
                mylib.setCookie('search-history', searchHistoryData);
                $(this).parent().remove();
                //console.log('ִ����ɾ��');
                return false;
            });
        }

        //��껮��
        $('.search-layout').find('li').mouseover(function(){
            $('.search-layout').find('li').removeClass('active');
            $(this).addClass('active');
        });

        //����ؼ��ʿ�ʼ����
        $('.search-layout').find('li').click(function(){
            var keyword = $(this).data('keyword');
            $('.search-input').find('input').val(keyword);

            $('.search-input').find('a').click();
            $('.search-layout').hide();
            //console.log('ִ���˵��');
            return false;
        });
        //�������������ķŴ󾵽�������
        $('.search-input').find('a').click(function(){
            var url = '/main/search';
            var keyword= $(this).prev('input').val();
            if($.trim(keyword) != ''){
                //���ؼ��ʼ�¼��cookie

                if($.isArray(searchHistory)){
                    if(searchHistory.indexOf(keyword) == -1){
                        //console.log('aaa');
                        searchHistory.unshift(keyword);
                        if(searchHistory.length >5){
                            searchHistory.pop();
                        }
                    }else{
                        //ɾ����ͷ���������
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
                mylib.msg('�������ݲ���Ϊ��');
            }

        });
        //���س��ύ����
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

    //��ESC�ر������
    $(document).keydown(function (e) {
        if (e.which === 27) {
            mylib.closePopup();
        }
    });
    //ȫ��ר������ȫ��
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
    /!*�����û���Ϣ*!/
    function loadUser(){
        var _user = mylib.getUserDataByCookie();
        var userUrl = mylib.getUserUrl();
        if(_user){
            var _name = decodeURI(_user[1]);//�û���

            _name = _name.substr(0, 5);
            var _userId = _user[0];
            var _userImg=mylib.getUrl('user')+'/static/imgs/default_user_pic.png';//�û�ͷ��
            var redirectUrl = encodeURIComponent(window.location.href);
            //���������ж�
            if($(".header-content").length>0){
                var _userNav='<div class="header-nav"><div class="user-nav">';
                _userNav+='<ul class="login-state">';
                _userNav+='<li class="message" id="sixin"><label></label><a href="'+userUrl+'/user/all-message" target="_blank">˽��</a></li>';
                _userNav+='<li class="notice" id="tixing"><label></label><a href="'+userUrl+'/user/notice" target="_blank">����</a></li>';
                _userNav+='<li class="avatar"><a href="#"><img src="'+_userImg+'"></a><label class="triangle_down_gray"></label></li>';
                _userNav+='</ul>';
                _userNav+='<ul class="drop-down-list">';
                _userNav+='<li class="menu"><a href="'+userUrl+'/user/personal-homepage?uid='+_userId+'" target="_blank"><label class="iconfont icon-geren"></label><span>������ҳ</span></a></li>';
                _userNav+='<li class="line"></li><li class="menu"><a href="'+userUrl+'/user/personal-homepage?uid='+_userId+'&amp;click=my-article"><label class="iconfont icon-wenzhang"></label><span>�ҵ�����</span></a></li>';
                _userNav+='<li class="line"></li><li class="menu"><a href="'+userUrl+'/user/user-setting"><label class="iconfont icon-shezhi"></label><span>�˺�����</span></a></li>';
                _userNav+='<li class="line"></li><li class="menu"><a href="'+userUrl+'/main/logout?redirectUrl="'+redirectUrl+'"><label class="iconfont icon-tuichu"></label><span>�˳�</span></a></li>';
                _userNav+='<li class="arrows"></li>';
                _userNav+='</ul></div></div>';
                $(".header-content").append('<div style="display:inline-block;float:right;height:65px;">'+_userNav+'</div>');

                //����֪ͨ�� ˽���� ���û�ͷ��
                $.ajax({
                    url: userUrl+'/user/get-user-tips',
                    type: 'GET',
                    dataType: 'jsonp',
                    data: {},
                    success : function(res){
                        if(res.code == 0){
                            if (res.xiaoxi > 0) {      //֪ͨ
                                $('.user-nav #tixing').append($('<span class="tip">'+res.xiaoxi+'</span>'));
                            }
                            if (res.sixin > 0) {       //˽��
                                $('.user-nav #sixin').append($('<span class="tip">'+res.sixin+'</span>'));
                            }
                            $('.user-nav .avatar').find('img').attr('src', res.avatar);
                        }
                    }
                });
            }else if($(".header-index-right").length>0){
                var _userNav='<div class="header-nav"><div class="user-nav">';
                _userNav+='<ul class="login-state">';
                _userNav+='<li class="message" id="sixin"><label></label><a href="'+userUrl+'/user/all-message" target="_blank">˽��</a></li>';
                _userNav+='<li class="notice" id="tixing"><label></label><a href="'+userUrl+'/user/notice" target="_blank">����</a></li>';
                _userNav+='<li class="avatar"><a href="#"><img src="'+_userImg+'"></a><label class="triangle_down_gray"></label></li>';
                _userNav+='</ul>';
                _userNav+='<ul class="drop-down-list">';
                _userNav+='<li class="menu"><a href="'+userUrl+'/user/personal-homepage?uid='+_userId+'" target="_blank"><label class="iconfont icon-geren"></label><span>������ҳ</span></a></li>';
                _userNav+='<li class="line"></li><li class="menu"><a href="'+userUrl+'/user/personal-homepage?uid='+_userId+'&amp;click=my-article"><label class="iconfont icon-wenzhang"></label><span>�ҵ�����</span></a></li>';
                _userNav+='<li class="line"></li><li class="menu"><a href="'+userUrl+'/user/user-setting"><label class="iconfont icon-shezhi"></label><span>�˺�����</span></a></li>';
                _userNav+='<li class="line"></li><li class="menu"><a href="'+userUrl+'/main/logout?redirectUrl="'+redirectUrl+'"><label class="iconfont icon-tuichu"></label><span>�˳�</span></a></li>';
                _userNav+='<li class="arrows"></li>';
                _userNav+='</ul></div></div>';
                $(".header-index-right").append('<div style="display:inline-block;float:right;height:46px;">'+_userNav+'</div>');

                //����֪ͨ�� ˽���� ���û�ͷ��
                $.ajax({
                    url: userUrl+'/user/get-user-tips',
                    type: 'GET',
                    dataType: 'jsonp',
                    data: {},
                    success : function(res){
                        if(res.code == 0){
                            if (res.xiaoxi > 0) {      //֪ͨ
                                $('.user-nav #tixing').append($('<span class="tip">'+res.xiaoxi+'</span>'));
                            }
                            if (res.sixin > 0) {       //˽��
                                $('.user-nav #sixin').append($('<span class="tip">'+res.sixin+'</span>'));
                            }
                            $('.user-nav .avatar').find('img').attr('src', res.avatar);
                        }
                    }
                });
            }else{
                var _userNav='<div class="header-login-yet">';
                _userNav+=' <a id="sixin" href="'+userUrl+'/user/all-message" target="_blank">˽��</a>';
                _userNav+=' <a id="xiaoxi" href="'+userUrl+'/user/notice" target="_blank">����</a>';
                _userNav+=' <div class="header-user j-header-user">';
                _userNav+='     <img src="'+_userImg+'" alt="ͷ��">';
                _userNav+='     <span>'+_name+'</span>';
                _userNav+='     <em></em>';
                _userNav+='     <ul class="set-menu j-set-menu">';
                _userNav+='         <li class="set-menu-1"><a href="'+userUrl+'/user/personal-homepage?uid='+_userId+'" target="_blank"><i></i><span>�ҵ���ҳ</span></a></li>';
                _userNav+='         <li class="set-menu-4"><a href="'+userUrl+'/user/personal-homepage?uid='+_userId+'&amp;click=my-article" target="_blank"><i></i><span>�ҵ�����</span></a></li>';
                _userNav+='         <li class="set-menu-2"><a href="'+userUrl+'/user/user-setting" target="_blank"><i></i><span>����</span></a></li>';
                _userNav+='         <li class="set-menu-3"><a href="'+userUrl+'/main/logout?redirectUrl="'+redirectUrl+'"><i></i><span>�˳�</span></a></li>';
                _userNav+='     </ul>';
                _userNav+=' </div>';
                _userNav+='</div>';
                $(".header .header-right").html(_userNav);

                //����֪ͨ�� ˽���� ���û�ͷ��
                $.ajax({
                    url: userUrl+'/user/get-user-tips',
                    type: 'GET',
                    dataType: 'jsonp',
                    data: {},
                    success : function(res){
                        if(res.code == 0){
                            if (res.xiaoxi > 0) {      //֪ͨ
                                $('.header-login-yet > #xiaoxi').html('����<i class="warm-spots"></i>');
                            }
                            if (res.sixin > 0) {       //˽��
                                $('.header-login-yet > #sixin').html('˽��<i class="warm-spots"></i>');
                            }
                            $('.header-user > img').attr('src', res.avatar);
                        }
                    }
                });
            }
        }else{
            if($(".header-content").length>0){
                var _nav = '<div style="display:inline-block;float:right;height:65px;"><span class="login-image"></span><a class="popup-login" style="display:inline-block;line-height:65px;font-size:17px;" href="javascript:;">��¼</a>&nbsp;/&nbsp;<a class="popup-register" style="display:inline-block;line-height:65px;font-size:17px;" href="javascript:;">ע��</a></div>';
                $(".header-content").append(_nav);
            }else if($(".header-index-right").length>0){
                var _nav = '<div class="header-index-login"><a class="j-log popup-login" href="javascript:;">��¼</a>&nbsp;&nbsp;<a class="j-log-r popup-register" href="javascript:;">ע��</a></div>';
                $(".header-index-right").html(_nav);
            }else{
                var _nav = '<div class="header-login-no"><a class="j-log popup-login" href="javascript:;">��¼</a>&nbsp;&nbsp;<a class="j-log-r popup-register" href="javascript:;">ע��</a></div>';
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
        var arr_week = new Array("������", "����һ", "���ڶ�", "������", "������", "������", "������");
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
                });//������¼��
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
        //��ҳ������ע
        $('body').on('click','.fastNews-attend', function(event){
            var _user = mylib.getUserDataByCookie();
            that = $(this);
            if(!_user){
                mylib.login(function() {
                    window.location.reload(true);
                });//������¼��
                return;
            }else{
                to_uid = $(this).parent().attr('to-uid');
                $('li[to-uid='+to_uid+']').find('.fastNews-attend').text('�ѹ�ע').attr('attended','done');
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
                            item+='<div class="fastNews-attend"><span>+</span>��ע</div>';
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
                });//������¼��
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
        //��������ط��ر�������
        $(document).click(function(ev) {
            //$('.notice-box').hide();
            layOutHide();
            hasClickNotice = false;

        });
        //���һ������ ��ȥ�����ѿ�
        $('#xiaoxi').on('click', '.notice-item', function() {
            $(this).closest('.notice-box').remove();
            hasClickNotice = false;
        });
        //������ȫ��֪ͨ��ť
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
                        //����б�
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
        //���һ������ ��ȥ�����ѿ�
        $('.notice').on('click', '.notice-item', function() {
            $(this).closest('.notice-box').remove();
            hasClickNotice = false;
        });
        //������ȫ��֪ͨ��ť
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
                        //����б�
                        $(that).closest('.notice-box').find('li').remove();
                        $('.notice').find('.tip').remove();
                    }
                }
            });
            return false;
        });

        //����հ״� �رվٱ�
        // $(document).click(function(event) {
        //     if(layOut) layer.close(layOut);
        // });

    }else if(hostName == 'm'){
        $('body').on('click', 'a.collect', function(event){
            var _user = mylib.getUserDataByCookie();
            if(!_user){
                mylib.login(function() {
                    window.location.reload(true);
                });//������¼��
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
                                alert('�ղسɹ���');
                            }else if(res.data.action=='cancel'&&$('#count0').text()!=0){
                                alert('��ȡ���ղ�');
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
            var _name = decodeURI(_user[1]);//�û���

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
