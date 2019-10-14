@extends('home.default1')
@section('content')
    <style scoped>

        .button-success,
        .button-error,
        .button-warning,
        .button-secondary {
            color: white;
            border-radius: 4px;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
        }

        .button-success {
            background: rgb(28, 184, 65); /* this is a green */
        }

        .button-error {
            background: rgb(202, 60, 60); /* this is a maroon */
        }

        .button-warning {
            background: rgb(223, 117, 20); /* this is an orange */
        }

        .button-secondary {
            background: rgb(66, 184, 221); /* this is a light blue */
        }
        .button-xsmall {
            font-size: 70%;
        }

        .button-small {
            font-size: 85%;
        }

        .button-large {
            font-size: 110%;
        }

        .button-xlarge {
            font-size: 125%;
        }

        .content {
            /* margin: -3px; */
            margin-left: 350px;
            margin-right: 300px;
            /*border-bottom:  1px solid rgba(0,0,0,0.2);
            border-top:  1px solid rgba(0,0,0,0.2);*/
        }
        .posts{
            border-top:  1px solid rgba(0,0,0,0.2);
        }
        .posts:last-child{
            border-bottom:  1px solid rgba(0,0,0,0.2);
            /*border-top:  1px solid rgba(0,0,0,0.2);*/
        }

        div.tab{
            margin-top: 30px;
            margin-bottom: 5px;
        }
        div.tab a{
            padding: 5px 10px;
        }

        section.post {
            margin-top: 40px;
            margin-bottom: 40px;
        }
        img.post-avatar {
            float: right;
            border-radius: 30px;

        }
        .post-description {
            margin-top: 20px;
        }



    </style>
    <div class="content">
        <br>
        <div class="tab">
            <a href="{{asset('suggestion')}}" class="button-xbig button-success pure-button">全部</a>
            @if(!Auth::guest())
            <a href="{{asset('suggestion/my')}}" class="button-xbig button-error pure-button" style="background: rgb(45,122,233);">我的</a>
            <a href="{{asset('add_suggestion')}}" class="button-xbig button-error pure-button" style="background: rgb(233,122,233); margin-left:80%">添加</a>
            @endif
        </div>
        <span><a href=""></a></span>
        @foreach ($suggestions as $message)
            <div class="posts">

                <!-- A single blog post -->
                <section class="post">
                    <header class="post-header">

                        <h2 class="post-title">
                            <a style="color:#888;font-size:18px;" href="{{URL('suggestion_detail')}}/{{ $message->id }}" title="全部内容">{{$message->title}}</a>
                                @if($message->response)
                                    <label style="color: #2fa360; font-size: 5px" id="status">{{"已回复"}}</label>
                                @endif

                            <a style="border:1px solid #FFF;" href="{{URL('/profile/')}}/{{$message->user_id}}"><img width="48" height="48" src="{{$message->user_avatar}}" alt="" class="post-avatar "></a>
                        </h2>

                    <!--                             <p class="post-meta">
                                By <a class="post-author" title="了解他" href="{{URL('/profile/')}}/id">name</a> under <a href="#" class="post-category post-category-design">CSS</a> <a href="#" class="post-category post-category-pure">Ajax</a>
                            </p> -->
                    </header>

                    <div class="post-description">
                        <p style="font-size:14px;letter-spacing:2px">
                            <?php echo preg_replace("/(\s|\&nbsp\;|\&|　|\xc2\xa0)/", "", strip_tags(str_limit($message->content, $limit = 100, $end = '...'))); ?>
                        </p>
                    </div>
                </section>
                <h8 class="content-subhead">{{date("Y-m-d H:i:s",strtotime($message->created_at))}}
                    <div id='k'>
                        @if($message->variety==1)
                            <span id='tp' style="background: rgb(221,111,222);"></span>
                            <a href="">建议</a>
                        @else
                            <span id='tp' style="background: red;"></span>
                            <a href="">反馈</a>
                        @endif
                    </div>
                </h8>
            </div>
        @endforeach

    <?php echo $suggestions->render(); ?>
    </div>

@endsection