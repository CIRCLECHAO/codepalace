{{--<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="dcom">--}}
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <div class="content">
        {{csrf_field()}}
        @yield('content')
    </div>
{{--
</div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="http://libs.baidu.com/jquery/2.1.1/jquery.min.js"></script>
    <script src="{{asset('plugins/layer/layer.js')}}"></script>
</body>
</html>--}}
