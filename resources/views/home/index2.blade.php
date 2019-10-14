@extends('home.default1')
@section('content')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <link href="{{ asset('font/iconfont.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link href="{{ asset('css/m.css') }}" rel="stylesheet">
    <!-- wrapper -->
    <div class="wrapper">
        <!-- hot-topic-nav -->
        <div class="hot-topic-nav">
            <span class="title2">热门话题：</span>
            <a href="{{ URL('') }}/" class="tag">全部</a>
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
            <div class="index-list">
                <!-- order-control -->
                <div class="order-control">
                    <ul class="clearfix">
                        <a href="{{ URL('/0/1/') }}">
                        <li
                                @if($type==1)
                                class="orderby-button active"
                                @else
                                class="orderby-button "
                                @endif
                                data-value="1" id="orderby-my-attention">我的关注</li>
                        </a>

                        <a href="{{ URL('/') }}">
                        <li
                                @if(!$type||$type==2)
                                class="orderby-button active"
                                @else
                                class="orderby-button "
                                @endif
                                data-value="2" id="orderby-last-publish">最新发布</li>
                        </a>
                        <a href="{{ URL('/0/3/') }}">
                        <li
                                @if($type==3)
                                class="orderby-button active"
                                @else
                                class="orderby-button "
                                @endif
                                data-value="3" id="orderby-big-view">专家文章</li>
                        </a>
                        <a href="{{ URL('/0/4/') }}">
                        <li
                                @if($type==4)
                                class="orderby-button active"
                                @else
                                class="orderby-button "
                                @endif
                                data-value="4" id="orderby-last-comment">最新回复</li>
                        </a>
                       {{-- <li class="orderby-button" data-value="6" id="orderby-3-day-hot">3天最热<i class="arrow-down"></i></li>--}}
                        {{--<ul class="order-control-drop-down" style="display: none">
                            <li data-value="3" id="orderby-24-hot">24小时</li>
                            <li data-value="6">3天</li>
                            <li data-value="7" id="orderby-7-day-hot">7天</li>
                            <li data-value="8" id="orderby-3-month-hot">3个月</li>
                        </ul>--}}
                    </ul>
                </div>
                <!-- ./ order-control -->
                <!-- 1 -->
                <ul class="home article-list orderby-last-comment"></ul>

                <!-- 2 -->
                <ul class="home article-list active orderby-last-publish">
                    @if(count($articles)>0)

                    @foreach($articles as $article)
                    <li>
                        <!-- user-box -->
                        <div class="user-box user-info-box clearfix">
                            <div class="user-avatar popup-user list-avatar" onmouseover="show_info(this)" onmouseleave="hide_info(this)">
                                <img src="{{ $article->avatar }}">
                                {{--名片悬浮--}}
                                <div class="popup-user-box" style="display: none;background-image: url('{{ $article->card_background_image }}');background-repeat: no-repeat;background-size:cover;">
                                    <div class="icon"></div>
                                    <div class="user-info-top">
                                        <div class="user-info-main clearfix">
                                            <div class="user-photo">
                                                <img src="{{ $article->avatar
                                                 }}" style="cursor: pointer;"></div>
                                            <div class="user-main">
                                                <div class="user-nick">
                                                    <a href="{{URL('profile')}}/{{ $article->user_id }}" target="_blank">{{ $article->user_name }}</a>
                                                </div>
                                                <div class="user-other"><p><?php echo strip_tags($article->description) ?></p>
                                                </div>
                                            </div>
                                            <div class="user-info-interact clearfix">
                                                <div class="box"><span>发帖</span><span>{{ $article->article_num }}</span></div>
                                                <div class="line"></div>
                                                <div class="box"><span>评论</span><span>{{ $article->comment_num }}</span></div>
                                                <div class="line"></div><div class="box"><span>粉丝</span><span>{{ $article->fans_num??0 }}</span></div>
                                            </div></div></div><div class="user-info-bottom clearfix">
                                        <div class="attention pay-attention" data-id="{{ $article->user_id }}">
                                            @if(in_array($article->user_id,$user_focus_arr))
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
                            <div class="user-main list-user-main">
                                <h4 class="clearfix">
                                    <a href="{{ URL('profile') }}/{{ $article->user_id }}" target="_blank">{{ $article->user_name }}</a>
                                    <p class="desc">{{ strip_tags($article->description) }}</p>
                                    @if($article->is_top)
                                    <span class="top">置顶</span>
                                        @endif
                                    @if($article->is_expert)
                                        <span class="expert">专家</span>
                                    @endif
                                    @if($article->is_fantastic)
                                        <span class="fantastic">牛人</span>
                                    @endif
                                    @if(!$article->is_checked)
                                        <span class="unchecked">审核中</span>
                                    @endif
                                </h4>
                                <span class="time" style="display: none">{{ $article->created_at }}</span>
                            </div>

                            </div>
                        <!-- ./ user-box -->

                        <!-- list-item -->
                        <div class="list-item">

                            <h4><a href="{{ URL('article_show') }}/{{ $article->id }}" target="_blank">{{ $article->title }}</a></h4>
                            

                            
                            <div class="item-info">
                                <div class="item-pic">

                                    <a href="{{ URL('article_show') }}/{{ $article->id }}" target="_blank">
                                        @if($article->title_pic)
                                        <img src="{{ $article->title_pic }}">
                                            @else
                                        <img src="{{ asset('images/code.jpg') }}">
                                        @endif
                                    </a>
                                </div>

                                <div class="item-content">
                                    <?php echo   str_limit(strip_tags($article->content), $limit = 350, $end = '...'); ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <!-- ./ list-item -->
                        <!-- op-tools -->
                        <div class="op-tools">
                            <ul class="clearfix">
                                <li class="shared-box" data-id="">
                                    <a href="javascript:;" class="share">分享</a>
                                    <div class="shared-items social-share"
                                    data-title="代码殿堂-{{ $article->title }}"
                                    data-description="分享来自代码殿堂"
                                    data-url="{{ URL('article_show') }}/{{ $article->id }}">
                                        <a class="arrows"></a>
                                    </div>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        点击<span>{{ $article->click }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;"
                                       @if(in_array($article->id,$user_collect_arr))
                                       class="collection active"
                                       @else
                                       class="collection "
                                       @endif
                                       data-type="2" data-id="{{ $article->id }}">
                                        收藏 <span>{{ $article->collect_num }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ URL('article_show') }}/{{ $article->id }}"

                                       @if(in_array($article->id,$user_comment_arr))
                                            class="comment active"
                                       @else
                                            class="comment "
                                       @endif
                                       data-type="2"
                                       data-id="{{ $article->id }}" target="_blank" >评论 <span>{{ $article->comments_num }}</span></a>
                                </li>
                                <li>
                                    <a href="javascript:;"
                                       data-id="{{ $article->id }}"
                                       @if(in_array($article->id,$user_zan_arr))
                                        class="praise active"
                                       @else
                                        class="praise "
                                       @endif

                                    >赞 <span>{{ $article->zan }}</span></a>
                                </li>


                                <li>
                                    <a href="" style="color:#ce3d3a;" target="_blank" class="topic_tag">{{ $article->category_name }}</a>
                                </li>
                            </ul>
                            <span class="time">{{ $article->created_at }}</span>
                            <div class="clear"></div>
                        </div>
                        </div>
                        <!-- ./ op-tools -->
                    </li>
                    @endforeach
                        {{ $articles->render() }}
                    @else
                        <div class="no_content">
                            <img class="no_content_img" src="{{ asset('images/no_content.jpg') }}">
                            <div class="no_content_word">
                                <p>这个页面</p>
                                <p>什么也没有</p>
                                <p>仿佛站长的钱包</p>
                                <p>那样虚无</p>
                            </div>
                        </div>
                    @endif
                </ul>

                <!-- 3 -->
                <ul class="home article-list orderby-24-hot"></ul>
                <!-- 4 -->
                <ul class="home article-list active orderby-my-attention"></ul>

                <!-- 5 -->
                <ul class="home article-list orderby-big-view"></ul>


                <!-- 6 -->
                <ul class="home article-list orderby-3-day-hot"></ul>
                <!-- 7 -->
                <ul class="home article-list orderby-7-day-hot"></ul>
                <!-- 8 -->
                <ul class="home article-list orderby-3-month-hot"></ul>


            </div>
            <!-- ./ box-left -->
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
                                                <?php echo strip_tags($last_admin_article->content) ?></div>
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
                <div class="panel-box">
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

                                    {{--<ul class="article-recommend">

                                    </ul>--}}
                                </div>
                                <!-- ./recomment-friends-box -->
                            </li>
                        @endforeach

                        </ul>
                        {{--<button class="load-all">查看全部</button>--}}
                    </div>
                </div>

                <!-- ./ recommend-remain-big-view  -->
            </div>
            <!-- ./ box-right -->
            <div class="clear"></div>
        </div>
        <!-- ./ main-tow -->
    </div>
    <!-- ./ wrapper -->

    <script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('plugins/layer/layer.js') }}"></script>
    <script src="{{ asset('js/mylib.js') }}"></script>
    <script src="{{ asset('js/index.js') }}"></script>
    <!-- footer -->


@endsection
