<!DOCTYPE html>
<html>
<head>
    <meta charset="gb2312">
    <title>{{ $html_title??"代码殿堂" }}</title>
    <meta name="baidu-site-verification" content="KH8QYVZUeK" />
    <meta name="360-site-verification" content="c5284da747d3ca372516acb6df028194" />
    <meta name="keywords" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="{{ asset('description') }}" content="" />
    <link rel="shortcut icon" href="{{ asset('images/cp.ico') }}" >
    <link href="{{ asset('css/base.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chat.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link href="{{ asset('css/share.min.css') }}" rel="stylesheet">
    <link href="{{ asset('js/ckeditor/plugins/codesnippet/lib/highlight/styles/monokai.css') }}" rel="stylesheet">
    <style>
        #he-plugin-simple{
            margin-left: 5px!important;
            margin-top: 10px!important;
            width: 100px;
            height: 40px;
            position: fixed!important;
        }
    </style>
</head>
<body>
<div class="fixedtop" >
<header class="default_header">

    <div class="weather-info" id="he-plugin-simple">    </div>

    <script>
            WIDGET = {
                CONFIG: {
                    "modules": "01234",
                    "background": 5,
                    "tmpColor": "4A4A4A",
                    "tmpSize": 16,
                    "cityColor": "4A4A4A",
                    "citySize": 16,
                    "aqiSize": 16,
                    "weatherIconSize": 24,
                    "alertIconSize": 18,
                    "padding": "10px 10px 10px 10px",
                    "shadow": "1",
                    "language": "auto",
                    "borderRadius": 5,
                    "fixed": "false",
                    "vertical": "middle",
                    "horizontal": "center",
                    "key": "30e7ad203ba14b6ba4c719e34f63106e"
                }
            }
        </script>
        <script src="https://widget.heweather.net/simple/static/js/he-simple-common.js?v=1.1"></script>

    <div id="logo"><a href="/"></a></div>
    <nav class="topnav" id="topnav">

        <div class="search-input">
            <input type="text" id="keyword" name="keyword" placeholder="输入作者名或者文章标题查询..." value="{{ $keyword??null }}">
            <a onclick="index_search(this);" href="javascript:void(0);" class="search_btn" ></a>
            {{--<div class="search-layout" style="">--}}
            {{--</div>--}}
        </div>

        <a href="/">
            <span>首页</span>
            <span class="en">Protal</span>
        </a>
        <a href="{{ url('/add_article') }}">
            <span>发帖处</span>
            <span class="en">Say</span>
        </a>

        <a href="{{ url('/suggestion') }}">
            <span>意见箱</span>
            <span class="en">Gustbook</span>
        </a>
    </nav>
    @if (count($errors) > 0)
        <div id="alert-error" class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif

    @if (Auth::guest())
      {{--  <a class="user_register" href="{{ url('/register') }}" class="button-register">注册</a>
         <label class="gang">/</label>
        <a class="user_login" href="{{ url('/login') }}" class="button-login">登录</a>--}}
        <div class="user_avatar">
            <a onclick="">
                <img width="48" height="48" src="{{ asset('images/cp.ico') }}" alt="" class=" ">
            </a>
            <ul class="drop-down-list" style="display: none">
                <li class="menu">
                    <a href="javascript:void(0);{{--{{ url('/login') }}--}}" onclick="open_login_dom();" class="personal-url login">
                        <label class="iconfont icon-geren"></label>
                        <span>登录</span>
                    </a>
                </li>
                <li class="line"></li>
                <li class="menu">
                    <a class="my-article register" href="javascript:void(0);" onclick="open_register_dom();">
                        <label class="iconfont icon-wenzhang"></label><span>注册</span>
                    </a>
                </li>
                <li class="line"></li>
                <li class="arrows"></li>
            </ul>
        </div>
    @else
        <div class="user_avatar">
            <a onclick="">
                @if(Auth::user()->avatar)
                    <img width="48" height="48" src="{{Auth::user()->avatar}}" alt="" class=" ">
                @else
                    <img width="48" height="48" src="{{ asset('images/default_avatar.jpg') }}" alt="" class=" ">
                @endif
            </a>
            <ul class="drop-down-list" style="display: none">
                <li class="menu">
                    <a href="{{ url('/profile') }}/{{ Auth::id() }}" class="personal-url">
                        <label class="iconfont icon-geren"></label><span>个人主页</span>
                    </a>
                </li>
                <li class="line"></li>
                <li class="menu"><a class="my-article" href="{{ url('/profile') }}/{{ Auth::id() }}"><label class="iconfont icon-wenzhang"></label><span>我的文章</span></a></li>
                <li class="line"></li>
                <li class="menu"><a href="{{ url('/user/settings') }}"><label class="iconfont icon-shezhi"></label><span>账号设置</span></a></li>
                <li class="line"></li>
                <li class="menu"><a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    <label class="iconfont icon-tuichu"></label>
                                     <span>退出</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                <li class="arrows"></li>
            </ul>


        </div>
            <div class="user_name"><label style="">{{Auth::user()->name}}</label></div>
    @endif
</header>
</div>
{{csrf_field()}}
@yield('content')
<footer>
    <div class="footer">
        <div class="wrapper clearfix">
            <ul class="clearfix">
                <li><a onclick="show_link_info(this);" href="javascript:void(0);">联系本站</a></li>
                <li><a onclick="show_about_info(this);" href="javascript:void(0);">关于本站</a></li>
                <li><a onclick="show_version_info(this);" href="javascript:void(0);">版权声明</a></li>
                <li><a onclick="show_duty_info(this);" href="javascript:void(0);">免责声明</a></li>
                <li><a onclick="show_log_info(this);" href="javascript:void(0);">更新日志</a></li>
                <li><a onclick="show_donation_info(this);" href="javascript:void(0);">捐赠本站</a></li>
                <li><a onclick="show_friend_link(this);" href="javascript:void(0);">友情链接</a></li>
            </ul>
            <p>Copyright © 2018-2019 代码殿堂 All rights reserved.</p>
            <p>皖ICP备18022737号</p>
        </div>
    </div>
    <!-- ./ footer -->
</footer>
<div class="chat_button">
    在线聊天
    <label class="total_unread_num"></label>
</div>

<div class="go-back" style=
"float: left; position: fixed; right: 1%; bottom: 1%; width: 38px; height: 38px; cursor: pointer; display: block;"></div>

<script src="{{asset('js/app.js')}}"></script>
<script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<script src="{{asset('plugins/layer/layer.js')}}"></script>
<script src="{{asset('js/dcom.js')}}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/jquery.share.min.js') }}"></script>
<script src="{{ asset('js/jquery.qqFace.js') }}"></script>
<script src="{{ asset('js/ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js') }}"></script>
<script>hljs.initHighlightingOnLoad();</script>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
{{--CNZZ--}}
<script type="text/javascript">
    var cnzz_s_tag = document.createElement('script');
    cnzz_s_tag.type = 'text/javascript';
    cnzz_s_tag.async = true;
    cnzz_s_tag.charset = 'utf-8';
    cnzz_s_tag.src = 'https://w.cnzz.com/c.php?id=cnzz_stat_icon_1275533163&cnzz_protocol=s5.cnzz.com/z_stat.php%3Fid%3D1275533163%26online%3D1';
    var root_s = document.getElementsByTagName('script')[0];
    root_s.parentNode.insertBefore(cnzz_s_tag, root_s);
</script>
<script>
    $('.go-back').click(
        function smoothscroll(){
        var currentScroll = document.documentElement.scrollTop || document.body.scrollTop;
        if (currentScroll > 0) {
            window.requestAnimationFrame(smoothscroll);
            window.scrollTo (0,currentScroll - (currentScroll/5));
        }
    })

    var alert_text = document.getElementById('alert-error');
    if(alert_text!=null){
        setTimeout(function(){
                alert_text.parentNode.removeChild(alert_text);
            },
            2000);
    }
    var time;


    $('.user_avatar img').mouseover(function () {
        clearTimeout(time);
        //$('.drop-down-list').show();
        $(".drop-down-list").slideDown();

    })

    $('.drop-down-list').mouseover(function () {
        clearTimeout(time);

        //$('.drop-down-list').show();
        $(".drop-down-list").slideDown();
    })

    $('.user_avatar img').mouseleave(function () {
       time= setTimeout(function () {
         //   $('.drop-down-list').hide();
           $(".drop-down-list").slideUp();

       },1000);
    })
    $('.drop-down-list').mouseleave(function () {
       time= setTimeout(function () {
            //$('.drop-down-list').hide();
           $(".drop-down-list").slideUp();

       },1000);
    })
</script>

</body>
</html>
