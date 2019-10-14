@extends('home.default1')
@section('content')
    <div class="main_content" style="border-bottom: 1px solid #eee;">
        <br>
        <div class="avatar"><img width="48" height="48" src="{{$article_show->avatar}}" alt="" class="post-avatar "></div>
        <div class="article_user_name">{{$article_show->user_name}}</div>
        <div class="article_detail">

            <div class="article_content"><h6><?php echo $article_show->content;?>
                </h6></div>
        <div class="article_other">
        <h8 class="content-subhead" style="border-bottom: 0px;">
            发布于 {{date("Y:m:d - H时i分",strtotime($article_show->created_at))}}
            <div id="k">
                <span id='tp' style="background: rgb({{ $article_show->color }});"></span>
                <a href="{{asset('/')}}{{$article_show->category}}">{{ $article_show->category_name }}</a>
            </div>
            </h8>
        </div>

        </div>
        <style type="text/css">
            img.post-avatar {
                display: block;
                /* margin-left: 47%; */
                width: 40px;
                height: 40px;
                border-radius: 20px;
                margin: 0 auto;
            }

            .article_user_name {
                border-bottom: 1px solid rgba(226, 226, 226, 0.66);
                padding-top: 10px;
                padding-bottom: 10px    ;
            }
            div.article_other {
                padding: 18px 0px;
                text-align: left;
            }
            .article_content {
                text-align: left;
                font-size: 16px;
            }
            .article_detail{
                padding-top: 20px;
                border-bottom: 1px solid ;
            }
            .avatar image{
                border-radius: 30px;
            }

            div.header{
                display: none;
            }
            .main_content{
                text-align: center;
                border-bottom: 1px solid #eee;
                margin-left: 350px;
                margin-right: 300px;

            }
            .img_h{width:40px;height: 40px;border-radius: 20px;}
            .nc{font-size: 12px;text-align: left;color: #7e7e7e;}
            #ontt{font-size: 12px;color: #252525;text-align: left;}
            #tm{color: #7e7e7e;font-size: 12px;margin-right: 100px;text-align: left;}

            .pl{margin: 20px;
            text-align: left}
        </style>

        @foreach ($comments as $com)
            <div class="pl">
                <img class="img_h" alt="" src="{{$com->avatar}}">
                <a class="nc" href="{{url('/profile')}}/{{ $com->user_id }}" alt="{{ $com->content }}">{{ $com->name }}</a><p id='tm'>{{ $com->created_at }}</p>
                <p id="ontt"><?php echo $com->content;?></p>
            </div>
        @endforeach
        <style scoped>

            .button-success,
            .button-error,
            .button-warning,
            .button-secondary {
                color: white;
                border-radius: 4px;
                text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
                font-size: 30%;
            }

            .button-success {
                background: rgb(28, 184, 65); /* this is a green */
                position: relative;
                top: -9px;
                left: 10px;
            }


        </style>
        <style type="text/css">
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
                background-color: #ffffff;
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
            .tj{
                background: RGB(230,230,230);
                color: black;
                /* text-align: center; */
                /* line-height: 33px; */
                /* width: 91px; */
                /* height: 33px; */
            }
        </style>
        <?php echo $comments->render(); ?>
        <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
        <h5 style="text-align: left;">发表回复</h5>
        <form class="pure-form pure-form-stacked" action="{{URL('/user/comments')}}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="article_id" value="{{ $article_show->id }}">
            <textarea id="editor" cols="20" rows="2" name="content" class="ckeditor"></textarea> <br>
            <input style="float: left" class="tj" type='submit' class='pure-button pure-button-default' value=" 发表 ">
        </form>
    </div>
@endsection
