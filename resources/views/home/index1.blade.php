@extends('home.default1')

@section('content')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <div class="banner">
    <section class="box">
        <ul class="texts">
            <p>我有一个小小愿望。</p>
            <p>在这个世界上，无论何时，无论春夏秋冬。</p>
            <p>码农们的代码不再会有BUG。</p>
        </ul>
        <div class="avatar"><a href="#"><span>ADMIN</span></a> </div>
    </section>
</div>

<article>
    <h2 class="title_tj">
        <p>文章<span>推荐</span></p>
    </h2>
    <div class="bloglist left">
        @foreach ($index as $message)
            @if($message->is_top)
                <div class="article_top">
                    <h3><a style="color:#888;font-size:18px;" href="{{URL('article_show')}}/{{$message->id}}" title="全部内容"><strong style="color: red">[置顶]</strong>{{$message->title}}</a><a style="border:1px solid #FFF;" href="{{URL('/Profile/')}}/{{$message->user_id}}">{{--<img width="48" height="48" src="{{$message->avatar}}" alt="" class="post-avatar ">--}}</a></h3>
                @else
                <div class="article">
                <h3><a style="color:#888;font-size:18px;" href="{{URL('article_show')}}/{{$message->id}}" title="全部内容">{{$message->title}}</a><a style="border:1px solid #FFF;" href="{{URL('/Profile/')}}/{{$message->user_id}}">{{--<img width="48" height="48" src="{{$message->avatar}}" alt="" class="post-avatar ">--}}</a></h3>
            @endif
        <figure><img src="images/001.png"></figure>
        <ul>
            <p>
                <?php echo preg_replace("/(\s|\&nbsp\;|\&|　|\xc2\xa0)/", "", str_limit(strip_tags($message->content), $limit = 350, $end = '...')); ?>
            </p>
            <a title="阅读全文" href="{{URL('article_show')}}/{{$message->id}}" target="_blank" class="readmore">阅读全文>></a>
        </ul>
        <p class="dateview">
            <span>{{date("Y-m-d H:i:s",strtotime($message->created_at))}}</span>
            <span>作者：{{ $message->user_name }}</span><span>个人博客：[<a href="">{{ $message->category_name }}</a>]&nbsp;&nbsp;&nbsp;&nbsp;点击({{ $message->click }})</span>
        </p>
            </div>
        @endforeach
        <?php echo $index->render(); ?>
    </div>
    <aside class="right">
        <div class="weather">
            <iframe width="250" scrolling="no" height="60" frameborder="0"
                    allowtransparency="true" src="http://i.tianqi.com/index.php?c=code&id=12&icon=1&num=1">
            </iframe></div>
        <div class="news">
            <h3>
                <p>最新<span>文章</span></p>
            </h3>
            <ul class="rank">
                @foreach ($new_articles as $message)
                    <li><a href="{{URL('article_show')}}/{{$message->id}}" title="{{$message->title}}" target="_blank">{{$message->title}}</a></li>
                @endforeach
            </ul>
            <h3 class="ph">
                <p>点击<span>排行</span></p>
            </h3>
            <ul class="paih">
                @foreach ($click_articles as $message)
                    <li><a href="{{URL('article_show')}}/{{$message->id}}" title="{{$message->title}}" target="_blank">{{$message->title}}</a></li>
                @endforeach            </ul>
            <h3 class="links">
                <p>友情<span>链接</span></p>
            </h3>
            <ul class="website">
                <li><a href="https://www.baidu.com">百度</a></li>
                <li><a href="https://www.google.com">GOOGLE</a></li>
                <li><a href="https://www.fclmw.cn">房产联盟网</a></li>
            </ul>
        </div>
        <!-- Baidu Button BEGIN -->
        <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
        <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
        <script type="text/javascript" id="bdshell_js"></script>
        <script type="text/javascript">
            document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
        </script>
        <!-- Baidu Button END -->
        <a href="/" class="weixin"> </a></aside>
    </div>
</article>
@endsection
