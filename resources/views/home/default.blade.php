<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="代码殿堂">
    <title>代码殿堂</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style type="text/css">
        .weather-info{
            position: absolute;
            right: 0px;
            top: 0px;
        }
        #tp{
            display: block;
            float: left;
            margin-top: 5px;
            margin-right: 4px;
            height: 12px;
            width: 12px;
            opacity: 0.8;
            border-radius: 6px;
        }
        #k{
            float: right;
        }
        .pagination {
            border-radius: 4px;
            display: inline-block;
            margin: 20px 0;
            padding-left: 0;
        }
        .pagination > li {
            display: inline;
        }
        .pagination > li > a, .pagination > li > span {

            border: 1px solid #dddddd;
            color: #337ab7;
            float: left;
            line-height: 1.42857;
            margin-left: -1px;
            padding: 6px 12px;
            position: relative;
            text-decoration: none;
        }
        .pagination > li:first-child > a, .pagination > li:first-child > span {
            border-bottom-left-radius: 4px;
            border-top-left-radius: 4px;
            margin-left: 0;
        }
        .pagination > li:last-child > a, .pagination > li:last-child > span {
            border-bottom-right-radius: 4px;
            border-top-right-radius: 4px;
        }
        .pagination > li > a:hover, .pagination > li > span:hover, .pagination > li > a:focus, .pagination > li > span:focus {
            background-color: #eeeeee;
            border-color: #dddddd;
            color: #23527c;
        }
        .pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
            background-color: #337ab7;
            border-color: #337ab7;
            color: #ffffff;
            cursor: default;
            z-index: 2;
        }
        div#layout {
            position: fixed;
            background: black;
            float: left;
            width: 120px;
            height: 100%;
        }
        div#layout ul {
            -webkit-padding-start:0px;
        }
        div#layout ul li{
            padding-left: 5px;

            list-style: none;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        div#layout ul li:nth-child(4){
            border-bottom: 1px solid rgba(226, 226, 226, 0.66);
        }
        div#layout ul li a{
            list-style: none;
            color: rgba(226, 226, 226, 0.66);
        }
        h1.fadeInDown.animated {
            text-align: center;
        }
        h2.flipInX.animated {
            text-align: center;
            color: grey;
        }

        div.header p {
            text-align: center;
            margin-top: 25px;
        }
        h8.content-subhead {
            color: rgba(0,0,0,0.5);
        }
        div#k a {
            color: black;
        }
        a.pure-menu-heading {
            padding-left: 5px;
            /*font-family: cursive;*/
            font-size: 18px;
            display: block;
            border-bottom: 1px solid rgba(226, 226, 226, 0.66);
            color: rgba(226, 226, 226, 0.66);
            padding-bottom: 10px;
            padding-top: 10px;
        }
        a.button-register {
            background: RGB(0,120,231);
            display: inline-block;
            color: white;
            /* text-align: center; */
            /* line-height: 33px; */
            /* width: 91px; */
            /* height: 33px; */
            padding: 5px 15px;
            border-radius:5%;

        }
        a.button-login {
            background: RGB(230,230,230);
            display: inline-block;
            color: black;
            /* text-align: center; */
            /* line-height: 33px; */
            /* width: 91px; */
            /* height: 33px; */
            padding: 5px 15px;
            border-radius:5%;
        }
        .user_avatar{
            text-align: left;
            padding-left: 5px;
        }
        .user_avatar img{
            border-radius: 30px;

        }
        .user_name{
            text-align: left;
            padding-left: 5px;
            color: #fff;
        }
        .alert-danger,.alert-info,.alert-warning{
            position: fixed;
            left: 45%;
            top: 10%;
            opacity: 0.9;
        }
    </style>
</head>
<body>


<div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <span></span>
    </a>
    @if (count($errors) > 0)
        <div id="alert-error" class="alert alert-danger">
                @foreach ($errors->all() as $error)
                     {{ $error }}
                @endforeach
        </div>
    @endif

    <div id="menu">
        <!-- <div id="menu" class="rotateInDownLeft animated"> -->
        <div class="pure-menu pure-menu-open">
            @if (Auth::guest())
            @else
                <div class="user_avatar"><img width="48" height="48" src="{{Auth::user()->avatar}}" alt="" class=" "><label style="color: #FFF;">{{Auth::user()->name}}</label></div>
            @endif
                <a class="pure-menu-heading" href="/">Code Palace</a>

            <ul>
                <!-- menu-item-divided pure-menu-selected -->
                <li>
                    <a href="{{ url('/add_article') }}">发布帖子</a>
                </li>
                {{--<li>
                    <a href="{{ url('/user/me') }}">帖子动态</a>
                </li>--}}

                @if (Auth::guest())
                @else
                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">退出登录</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                    <li>
                        <a href="{{ url('/user/settings') }}">个人设置</a>
                    </li>
                    <li>
                        <a href="{{ url('/profile')}}/{{Auth::id()}}">我的主页</a>
                    </li>
                @endif
                <li class="menu-item-divided ">
                    <a href="{{ url('/suggestion') }}">意见反馈</a>
                </li>
            </ul>
        </div>
    </div>
</div>


<div id="main">

    <!--版式-->

    <div class="header">
        <div>
            <h1 class="fadeInDown animated">Code Palace</h1>
         <?php $weather = json_decode(\Illuminate\Support\Facades\Cookie::get('weather')) ?>
        @if ($weather??null))
            <label class="weather-info">
            当前位置：{{ $weather->basic->cnty.' '.$weather->basic->admin_area.' '.$weather->basic->location }}
            天气：{{ $weather->now->cond_txt }},
                温度：{{ $weather->now->tmp }}℃, 风：{{ $weather->now->wind_dir }} ,{{ $weather->now->wind_sc }}级
            </label>
            @endif
        </div>
        <h2 class="flipInX animated">Code Create Everything!</h2>
        <p>
            @if (Auth::guest())
                <a href="{{ url('/register') }}" class="button-register">注册</a>
                <a href="{{ url('/login') }}" class="button-login">登录</a>
            @endif
        </p>
    </div>
    <div class="content">
        {{csrf_field()}}
        @yield('content')
    </div>
</div>
<script>
    var alert_text = document.getElementById('alert-error');
    if(alert_text!=null){
        setTimeout(function(){
                alert_text.parentNode.removeChild(alert_text);
            },
            2000);
    }
</script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>