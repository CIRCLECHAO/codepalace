@extends('home.default1')
@section('content')
    {{--<link href="{{ asset('css/main.css') }}" rel="stylesheet">--}}
<!-- wrapper -->
<div class="wrapper">
    <!-- hot-topic-nav -->
    <div class="hot-topic-nav">
        <span class="title2">热门话题：</span>
        <a href="{{ URL('') }}/" class="tag">全部</a>
        {{--@foreach($category as $c)
                <a href="{{ URL('') }}/{{ $c->id }}" class="tag">{{ $c->name }}</a>
        @endforeach--}}
        @foreach($category as $c)
            @if($c_id == $c['id'] )
                <a href="{{ URL('') }}/{{ $c['id'] }}/{{ $type }}/" class="tag active">{{ $c['name'] }}({{ $c['num'] }})</a>
            @else
                <a href="{{ URL('') }}/{{ $c['id'] }}/{{ $type }}/" class="tag">{{ $c['name'] }}({{ $c['num'] }})</a>
            @endif
        @endforeach
    </div>
    <!-- ./ hot-topic-nav -->

    <!-- main-tow -->
    <div class="main-tow">
        <!-- box-left -->
        <div class="box-left">
            <!-- article-content -->
            <div class="article-content">
                <div class="hot-topic-nav" style="padding:0 0 10px 0">

                    <a href="{{URL('/0')}}/{{ $article_show->category }}" class="tag">{{ $article_show->category_name }}</a>					</div>
                <h1>{{ $article_show->title }}</h1>
                <!-- user-box -->
                <div class="user-box user-info-box">
                    <div class="user-avatar popup-user" user-id="245203">
                        <img alt="" src="{{ $article_show->avatar }}">
                    </div>

                    <div class="user-main">
                        <h4><a href="{{URL('profile')}}/{{ $article_show->user_id }}" target="_blank">{{ $article_show->user_name }}</a></h4>
                        <p>{{ $article_show->description }}<span class="time1">{{ $article_show->created_at }}</span></p>
                    </div>
                </div>
                <!-- ./ user-box -->
                <!-- article-txt -->
                <div class="article-txt clearfix">
                    {{--文章内容--}}
                    <p><?php echo $article_show->content ?></p>
                </div>
                <div class="prev_and_next">
                    <ul>
                        @if($article_show->previous_article)
                            <li><a href="{{ URL('article_show') }}/{{ $article_show->previous_article->id }}">< < < 上一篇：{{ $article_show->previous_article->title }}</a></li>

                        @else
                            <li><a href="#">< < < 没有了</a></li>

                        @endif

                            @if($article_show->next_article)
                                <li><a href="{{ URL('article_show') }}/{{ $article_show->next_article->id }}">> > > 下一篇：{{ $article_show->next_article->title }}</a></li>

                            @else
                                <li><a href="#">> > > 没有了</a></li>

                            @endif

                    </ul>
                </div>
                {{--<div class="hot-topic-nav bottom-hot-topic-nav" style="padding:0 0 10px 0; display:none">
                    <a href="/topic/attention-topic?follow-topic-id=114112" class="tag">警察</a>
                </div>--}}
                <!-- ./ article-txt -->
                <!-- user-box -->

                <div class="user-box user-info-box article-bottom-user">

                    <div class="user-avatar popup-user" user-id="">
                        <img alt="" src="{{ $article_show->avatar }}">
                    </div>



                    <div class="user-main">
                        <h4><a href="{{URL('profile')}}/{{ $article_show->user_id }}" target="_blank">{{ $article_show->user_name }}</a></h4>
                        <p>
                            {{ $article_show->description }}
                            <span class="split">|</span>
                            <a class="article-count" href="{{URL('profile')}}/{{ $article_show->user_id }}" target="_blank">
                                {{ $article_show->article_num }}篇文章</a>
                            <span class="split">|</span>
                            <span class="attention-count">{{ $article_show->fans_num }}人关注</span>

                        </p>
                    </div>
                    <a class="btn attention" href="javascript:void(0);"   data-id="{{ $article_show->user_id }}">
                        @if(in_array($article_show->user_id,$user_focus_arr))
                            已关注
                        @else
                            +关注
                        @endif
                    </a>

                    {{--<div class="middle-title">--}}{{--观察者网用户社区--}}{{--</div>--}}
                </div>

                <!-- ./ user-box -->
                <!-- author-article -->
                <div class="author-article">
                    <div class="clearfix"><span class="title"><a href="{{URL('profile')}}/{{ $article_show->user_id }}/3" target="_blank">作者文章</a></span><span class="all"><a href="{{URL('profile')}}/{{ $article_show->user_id }}/3" target="_blank">查看全部>></a></span></div>
                    <ul>
                        @foreach($user_articles_show as $user_article)
                        <li><a href="{{URL('article_show')}}/{{ $user_article->id }}" target="_blank">{{ $user_article->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <!--  ./ author-article -->
                <!-- share-box -->
                <div class="share-box">
                    <ul>
                        <a href="javascript:;" class="share">分享</a>
                        <div class="shared-items social-share"
                             style="display: inline"
                             data-title="代码殿堂-{{ $article_show->title }}"
                             data-description="分享来自代码殿堂"
                             data-url="{{ URL('article_show') }}/{{ $article_show->id }}">
                            <a class="arrows"></a>
                        </div>
                    </ul>
                    <!-- op-tools -->
                    <div class="op-tools" style="margin-top: -35px">

                        {{--<a href="#"--}}
                           {{--data-id="54806" data-type="2">--}}
                            {{--收藏--}}
                            {{--<span>0</span></a>--}}

                        <a href="javascript:void(0);" class="comment">评论 <span>{{ $comments_num }}</span></a>
                        <a href="javascript:void(0);"
                           data-id="{{ $article_show->id }}"
                           @if(in_array($article_show->id,$user_zan_arr))
                           class="praise active"
                           @else
                           class="praise "
                                @endif
                        >
                            赞
                            <span>{{ $article_show->zan }}</span></a>
                    </div>
                    <!-- ./ op-tools -->
                </div>
                <!-- share-box -->
                <div class="clear"></div>
            </div>
            <h3 class="tab-control-header clearfix" data-area="2">我要评论</h3>

            <div class="add_comment">
                <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
                <form class="pure-form pure-form-stacked" action="{{URL('/user/comments')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="article_id" value="{{ $article_show->id }}">
                    <textarea id="editor" cols="20" rows="2" name="content" class="ckeditor"></textarea> <br>
                    <input style="" class="tj" type='submit' class='pure-button pure-button-default' value=" 发表 ">
                </form>
            </div>
            <!-- gc-comment -->
            <h3 class="tab-control-header clearfix" data-area="2">全部评论 <span>{{ $comments_num }}</span>条
                {{--<div class="tab-control list-order">		--}}
                    {{--<span data-order="2" class="hot">最热</span>		--}}
                    {{--<span data-order="3" class="old">最早</span>		--}}
                    {{--<span data-order="1" class="active new">最新</span>	--}}
                {{--</div>--}}
            </h3>
            <div class="comment-list">
                @foreach($comments as $comment)
                    <!-- user-box -->
                        <div class="user-box user-info-box clearfix user_comment">
                            <div class="user-avatar popup-user list-avatar" onmouseover="show_info(this)" onmouseleave="hide_info(this)">
                                <img src="{{ $comment->avatar }}">
                                {{--名片悬浮--}}
                                <div class="popup-user-box" style="display: none;background-image: url('{{ $comment->card_background_image }}');background-repeat: no-repeat;background-size:cover;">
                                    <div class="icon"></div>
                                    <div class="user-info-top">
                                        <div class="user-info-main clearfix">
                                            <div class="user-photo">
                                                <img src="{{ $comment->avatar
                                                 }}" style="cursor: pointer;"></div>
                                            <div class="user-main">
                                                <div class="user-nick">
                                                    <a href="{{URL('profile')}}/{{ $comment->user_id }}" target="_blank">{{ $comment->user_name }}</a>
                                                </div>
                                                <div class="user-other"><p><?php echo strip_tags($comment->description) ?></p>
                                                </div>
                                            </div>
                                            <div class="user-info-interact clearfix">
                                                <div class="box"><span>发帖</span><span>{{ $comment->article_num }}</span></div>
                                                <div class="line"></div>
                                                <div class="box"><span>评论</span><span>{{ $comment->comment_num }}</span></div>
                                                <div class="line"></div><div class="box"><span>粉丝</span><span>{{ $comment->fans_num??0 }}</span></div>
                                            </div></div></div><div class="user-info-bottom clearfix">
                                        <div class="attention pay-attention" data-id="{{ $comment->user_id }}">
                                            @if(in_array($comment->user_id,$user_focus_arr))
                                                已关注
                                            @else
                                                +关注
                                            @endif
                                        </div>
                                        <div class="line"></div>
                                        <div class="message">
                                            <a target="_blank" href="">私信</a>
                                        </div>
                                    </div>
                                </div>
                                {{----}}
                            </div>
                                <div class="user-main">
                                    <h4><a href="{{URL('profile')}}/{{ $comment->user_id }}" target="_blank">{{ $comment->user_name }}</a></h4>
                                    <p>  {{ $comment->description }}<span class="time1"></span></p>
                                    <div class="comment_content"><?php echo $comment->content ?></div>

                                </div>
                                <span class="time" style="margin-left: 46px">{{ $comment->created_at }}</span>

                        </div>
                        <!-- ./ user-box -->
                    @endforeach
                    <?php echo $comments->render(); ?>
            </div>
        </div>
        <!-- ./ box-left -->
        <!-- box-right -->
        <div class="box-right">
            <!-- 站内通知 -->
            <div class="panel-box">
                <h4 class="panel-header" style="color:#bf0b14">站内通知</h4>
                <div class="panel-body">
                    @if($last_admin_article)
                        <ul class="fw-affair">
                            <li>
                                <!-- user-box -->
                                <div class="user-box user-info-box clearfix">
                                    <div class="user-avatar popup-user" >
                                        <img src="{{ $last_admin_article->user->avatar }}">
                                    </div>
                                    <div class="user-main">
                                        <h4>
                                            <a href="{{ URL('profile') }}/{{ $last_admin_article->user_id }}"
                                               target="_blank">{{ $last_admin_article->user->name }}</a>
                                        </h4>
                                        <p>{{ strip_tags($last_admin_article->user->description) }}</p>
                                    </div>
                                </div>
                                <!-- ./ user-box -->

                                <!-- list-item -->
                                <div class="list-item">

                                    <h4><a href="{{ URL('article_show') }}/{{ $last_admin_article->id }}"
                                           target="_blank">{{ $last_admin_article->title }}</a></h4>
                                    <div class="item-info">
                                        <div class="item-content">
                                            <?php echo strip_tags($last_admin_article->content) ?>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <!-- ./ list-item -->
                                <!-- op-tools -->
                                <div class="op-tools">
                                    <ul>
                                        <li>
                                            <a href="{{ URL('article_show') }}/{{ $last_admin_article->id }}"
                                               @if(in_array($last_admin_article->id,$user_comment_arr))
                                               class="comment active"
                                               @else
                                               class="comment "
                                               @endif
                                               data-type="2"
                                               data-id="48973" target="_blank" >评论 <span>{{ $last_admin_article->comments_num }}</span></a>
                                        </li>
                                        <li>
                                            <a href="javascript:;"
                                               data-id="{{ $last_admin_article->id }}"
                                               @if(in_array($last_admin_article->id,$user_zan_arr))
                                               class="praise active"
                                               @else
                                               class="praise "
                                                    @endif
                                            >赞 <span>{{ $last_admin_article->zan }}</span></a>
                                        </li>
                                    </ul>
                                    <div class="clear"></div>
                                </div>
                                <!-- ./ op-tools -->
                            </li>
                        </ul>
                    @else
                        <ul>
                            <li>暂无</li>
                        </ul>
                    @endif

                </div>
            </div>
            <div class="division"></div>
            <!-- ./ affair -->

            <!-- 热评-->
            <div class="panel-box">
                <h4 class="panel-header">
                    <a href="" target="" style="color:#bf0b14">本站热评</a>
                </h4>
                <div class="panel-body">
                    @if($hot_comment)
                        <div class="fw-hot-comments">
                            <div class="article-title"><a href="{{ URL('article_show') }}/{{ $hot_comment->article_id }}" target="_blank">{{ $hot_comment->article->title }}</a></div>
                            <div class="hot-comment clearfix">
                                <span class="username"><a href="{{ URL('profile') }}/{{ $hot_comment->user_id }}" target="_blank">{{ $hot_comment->user->name }}</a></span> :
                                <p class="comment-content">
                                    <a href="{{ URL('article_show') }}/{{ $hot_comment->article_id }}" target="_blank">{{ strip_tags($hot_comment->content) }}</a>
                                </p>

                            </div>
                            <div class="tools clearfix">
                                <div class="praise-nums " data-id="11105656" >赞 <span>{{ $hot_comment->zan }}</span></div>
                                {{--  <a class="view-reply"href="/main/child-comments?id=11105656&s=fwsyfwrpckhf" target="_blank">查看回复 4</a>
                                  <a class="all-hots" href="/main/hot-comment-index?s=fwsyfwrpqbrp" target="_blank">全部热评</a>--}}
                            </div>
                        </div>
                    @else
                        <div>
                            暂无
                        </div>
                    @endif
                </div>
            </div>
            <div class="division"></div>

            <!-- ./ hot-comments -->
            <!-- recommend-big-view -->
            <!-- 全部用户 -->
            {{--<div class="panel-box">
                <h4 class="panel-header">全部用户</h4>
                <div class="panel-body left-recommend remian-big-view">

                    <ul>
                        @foreach($user_list as $user)
                            <li>
                                <!-- recomment-friends-box -->
                                <div class="recomment-friends-box user-info-box clearfix">
                                    <div class="user-avatar popup-user">
                                        @if($user->avatar)
                                            <img alt="" src="{{ $user->avatar }}">
                                        @else
                                            <img alt="" src="{{ asset('images/default_avatar.jpg') }}">
                                        @endif
                                    </div>
                                    <div class="user-main">
                                        <h4><a href="{{URL('profile')}}/{{ $user->id }}">{{ $user->name }}</a></h4>
                                        <p>{{ strip_tags($user->description) }}</p>
                                    </div>
                                    @if(in_array($user->id,$user_focus_arr))
                                        <a href="javascript:;" class="attention already-attention" data-id="{{ $user->id }}">已关注</a>
                                    @else
                                        <a href="javascript:;" class="attention pay-attention" data-id="{{ $user->id }}">+关注</a>
                                    @endif

                                    --}}{{--<ul class="article-recommend">

                                    </ul>--}}{{--
                                </div>
                                <!-- ./recomment-friends-box -->
                            </li>
                        @endforeach

                    </ul>
                    --}}{{--<button class="load-all">查看全部</button>--}}{{--
                </div>
            </div>--}}

            <!-- ./ recommend-remain-big-view  -->
        </div>
        <!-- ./ box-right -->
        <div class="clear"></div>
    </div>
    <!-- ./ main-tow -->
</div>
<!-- ./ wrapper -->

    <script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
    <script src="{{asset('js/jquery.lazyload.js')}}"></script>
    <script src="{{ asset('plugins/layer/layer.js') }}"></script>
    <script src="{{ asset('js/mylib.js') }}"></script>
    <script src="{{ asset('js/article_show.js') }}"></script>
    <script>
        jQuery(document).ready(function ($) {
            $("img.lazy").lazyload({effect: "fadeIn"});
        });
    </script>
@endsection
