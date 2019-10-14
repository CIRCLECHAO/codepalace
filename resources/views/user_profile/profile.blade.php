@extends('home.default1')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <br>
    <div class="wrapper">
        <!-- hot-topic-nav -->
        <div class="personal-top-nav clearfix" >
            <div class="user-avatar" ><img src="{{ $user_info->avatar }}" alt=""></div>
            <div class="user-info-box">
                <div class="user-nick">{{ $user_info->name }}<span></span></div>
                <div class="user-introduce"><span><?php echo($user_info->description) ?></span></div>
            </div>
            <div class="tools">
                <a class="attention" data-id="{{ $user_info->id }}">
                    @if(in_array($user_info->id,$user_focus_arr))
                        已关注
                    @else
                        +关注
                    @endif
                </a>
{{--
                <a class="message" data-href="/user/my-message?to_uid=242925">私信</a>
--}}
            </div>

        </div>
        <!-- ./ hot-topic-nav -->

        <!-- main-tow -->
        <div class="main-tow">
            <!-- box-left -->
            <div class="box-left new-comment-list gc-comment" id="comments-container">
                <ul class="personal-nav-li clearfix">
                    <li
                            @if(!$type)
                            class="active"
                            @endif
                            id="dynamic-li"><a href="{{ URL('profile') }}/{{ $user_info->id }}">动态</a></li>

                    <li
                            @if($type==1)
                            class="active"
                            @endif
                            id="reply-li"><a href="{{ URL('profile') }}/{{ $user_info->id }}/1">被回复&nbsp;{{ $user_info->be_commented_num }}</a></li>
                    <li
                            @if($type==2)
                            class="active"
                            @endif
                            id="comments-li"><a href="{{ URL('profile') }}/{{ $user_info->id }}/2">回复 <span>{{ $user_info->comments_num }}</span></a></li>
                    <li
                            @if($type==3)
                            class="active"
                            @endif
                            id="article-li"><a href="{{ URL('profile') }}/{{ $user_info->id }}/3">文章 <span>{{ $user_info->articles_num }}</span></a></li>
                    <li
                            @if($type==4)
                            class="active"
                            @endif
                            id="collect-li"><a href="{{ URL('profile') }}/{{ $user_info->id }}/4">收藏 <span>{{ $user_info->collects_num }}</span></a></li>
                    <li
                            @if($type==5)
                            class="active"
                            @endif
                            id="praise-li"><a href="{{ URL('profile') }}/{{ $user_info->id }}/5">赞 <span>{{ $user_info->zan_num }}</span></a></li>
                    <li class="attention-li" id="attention-li">
                        {{--<a>关注</a>
                        <ul class="attention-drop-down" style="display: none">
                            <li class="triangle_up_gray"></li>
                            <li class="attention-topic">关注话题 <span>0</span></li>

                        </ul>--}}
                    </li>
                </ul>

                <div class="line"></div>
                <ul class="article-list dynamic-list">
                    @if(count($dynamics)>0)
                    @foreach($dynamics as $dynamic)
                    <li class="pt14 pl4">
                        @if($dynamic->op_type==0)
                            @else
                            @if($dynamic->op_type==1)
                                <div class="user-action">发布了帖子
                                    <span class="action-time">{{ $dynamic->created_at }}</span></div>
                            @elseif($dynamic->op_type==2)
                                <div class="user-action">回复了帖子
                                    <span class="action-time">{{ $dynamic->created_at }}</span></div>
                            @elseif($dynamic->op_type==3)
                                <div class="user-action">赞了帖子
                                    <span class="action-time">{{ $dynamic->created_at }}</span></div>
                            @elseif($dynamic->op_type==4)
                                <div class="user-action">收藏了帖子
                                    <span class="action-time">{{ $dynamic->created_at }}</span></div>
                            @elseif($dynamic->op_type==5)
                                <div class="user-action">赞了评论
                                    <span class="action-time">{{ $dynamic->created_at }}</span></div>
                            @elseif($dynamic->op_type==6)
                                <div class="user-action">回复评论
                                    <span class="action-time">{{ $dynamic->created_at }}</span></div>
                            @endif
                            @endif

                            {{--被回复的数据结构 和回复的结构--}}
                        @if($type==1||$type==2)
                                <div class="user-box user-info-box">
                                    <div class="user-avatar user-info-lay popup-user" onmouseover="show_info(this)" onmouseleave="hide_info(this)">
                                        <img alt="" src="{{ $dynamic->user->avatar }}" style="cursor: pointer;">
                                        <div class="popup-user-box" style="
                                                display: none;
                                                background-image: url('{{ $dynamic->user->card_background_image }}');
                                                background-repeat: no-repeat;
                                                background-size:cover;">
                                            <div class="icon"></div>
                                            <div class="user-info-top">
                                                <div class="user-info-main clearfix">
                                                    <div class="user-photo">
                                                        <img src="{{ $dynamic->user->avatar
                                                 }}" style="cursor: pointer;"></div>
                                                    <div class="user-main">
                                                        <div class="user-nick">
                                                            <a href="{{URL('profile')}}/{{ $dynamic->user->id }}" target="_blank">{{ $dynamic->user->name }}</a>
                                                        </div>
                                                        <div class="user-other"><p><?php echo strip_tags($dynamic->user->description) ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="user-info-interact clearfix">
                                                        <div class="box"><span>发帖</span><span>{{ $dynamic->user->article_num }}</span></div>
                                                        <div class="line"></div>
                                                        <div class="box"><span>评论</span><span>{{ $dynamic->user->comment_num }}</span></div>
                                                        <div class="line"></div><div class="box"><span>粉丝</span><span>{{ $dynamic->user->fans_num??0 }}</span></div>
                                                    </div></div></div><div class="user-info-bottom clearfix">
                                                <div class="attention pay-attention" data-id="{{ $dynamic->user->id }}">
                                                    @if(in_array($dynamic->user->id,$user_focus_arr))
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
                                    </div>



                                    <div class="user-main clearfix">
                                        <h4><a href="{{URL('profile')}}/{{ $dynamic->user->id }}" target="_blank">{{ $dynamic->user->name }}</a></h4>
                                        <p><?php echo ($dynamic->user->description) ?></p>
                                    </div>
                                </div>
                                <div class="comment-txt">
                                    <p>
                                        <?php echo  strip_tags(str_limit($dynamic->content, $limit = 100, $end = '...')); ?>
                                    </p>
                                </div>
                                <div class="list-footer clearfix">
                                    <span class="time">{{ $dynamic->created_at }}</span>
                                    <div class="operations">
                                        <a href="javascript:;" class="accusation" >举报</a>
                                        <a href="javascript:;" class="comment" >回复</a>
                                        <a href="javascript:;" >踩<span>{{ $dynamic->cai }}</span></a>
                                        <a href="javascript:;" >赞<span>{{ $dynamic->zan }}</span></a>
                                    </div>
                                </div>

                                <p class="post-link">来自文章 ：<a href="{{URL('article_show')}}/{{ $dynamic->article_id }}"  target="_blank">{{ $dynamic->article_title }}</a></p>
                          {{--发表的文章 结构 标题 - 内容--}}
                            @elseif($type==3 && $dynamic->content)
                                <h4 class="article-title">
                                    <a href="{{URL('article_show')}}/{{ $dynamic->id }}" target="_blank">{{ $dynamic->title }} <span class="action-time">{{ $dynamic->created_at }}</span> </a>
                                </h4>
                                <div class="list-item">
                                    <p>
                                        <?php echo  strip_tags(str_limit($dynamic->content, $limit = 100, $end = '...')); ?>
                                    </p>
                                    <div class="clear"></div>
                                </div>
                            @elseif(is_object($dynamic->content))
                                <h4 class="article-title">
                                    <a href="{{URL('article_show')}}/{{ $dynamic->content->id }}" target="_blank">{{ $dynamic->content->title }}</a>
                                </h4>
                                <div class="user-box user-info-box">
                                    <div class="user-avatar user-info-lay popup-user" onmouseover="show_info(this)" onmouseleave="hide_info(this)">
                                        <img alt="" src="{{ $dynamic->user->avatar }}" style="cursor: pointer;">
                                        <div class="popup-user-box" style="
                                                display: none;
                                                background-image: url('{{ $dynamic->user->card_background_image }}');
                                                background-repeat: no-repeat;
                                                background-size:cover;">
                                            <div class="icon"></div>
                                            <div class="user-info-top">
                                                <div class="user-info-main clearfix">
                                                    <div class="user-photo">
                                                        <img src="{{ $dynamic->user->avatar
                                                 }}" style="cursor: pointer;"></div>
                                                    <div class="user-main">
                                                        <div class="user-nick">
                                                            <a href="{{URL('profile')}}/{{ $dynamic->user->id }}" target="_blank">{{ $dynamic->user->name }}</a>
                                                        </div>
                                                        <div class="user-other"><p><?php echo strip_tags($dynamic->user->description) ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="user-info-interact clearfix">
                                                        <div class="box"><span>发帖</span><span>{{ $dynamic->user->article_num }}</span></div>
                                                        <div class="line"></div>
                                                        <div class="box"><span>评论</span><span>{{ $dynamic->user->comment_num }}</span></div>
                                                        <div class="line"></div><div class="box"><span>粉丝</span><span>{{ $dynamic->user->fans_num??0 }}</span></div>
                                                    </div></div></div><div class="user-info-bottom clearfix">
                                                <div class="attention pay-attention" data-id="{{ $dynamic->user->id }}">
                                                    @if(in_array($dynamic->user->id,$user_focus_arr))
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
                                    </div>



                                    <div class="user-main clearfix">
                                        <h4><a href="{{URL('profile')}}/{{ $dynamic->user->id }}" target="_blank">{{ $dynamic->user->name }}</a></h4>
                                        <p><?php echo ($dynamic->user->description) ?></p>
                                    </div>
                                </div>
                                <div class="list-item">
                                    <p>
                                        <?php echo  strip_tags(str_limit($dynamic->content->content, $limit = 100, $end = '...')); ?>
                                    </p>
                                    <div class="clear"></div>
                                </div>
                                <div class="op-tools" style="position:relative">
                                    <a href="javascript:;" class="share-bbs" data-id="49439" style="cursor:pointer;">分享</a>
                                    <a href="javascript:;"
                                       @if(in_array($dynamic->article_id,$user_collect_arr))
                                       class="collection active"
                                       @else
                                       class="collection "
                                       @endif
                                       data-type="2" data-id="{{ $dynamic->article_id }}">
                                        收藏 <span>{{ $dynamic->content->collect_num }}</span>
                                    </a>
                                    {{--<a href="javascript:;" class="collection " data-type="2" data-id="49439">--}}
                                        {{--收藏<span>{{ $dynamic->content->collect_num }}</span>--}}
                                    {{--</a> --}}
                                    <a href="{{ URL('article_show') }}/{{ $dynamic->article_id }}"

                                       @if(in_array($dynamic->article_id,$user_comment_arr))
                                       class="comment active"
                                       @else
                                       class="comment "
                                       @endif
                                       data-type="2"
                                       data-id="{{ $dynamic->article_id }}" target="_blank" >评论 <span>{{ $dynamic->content->comment_num }}</span></a>
                                    {{--<a href="javascript:;" class="comment" data-type="2" >--}}
                                        {{--评论 <span>{{ $dynamic->content->comment_num }}</span>--}}
                                    {{--</a> --}}
                                    <a href="javascript:;"
                                       data-id="{{ $dynamic->article_id }}"
                                       @if(in_array($dynamic->article_id,$user_zan_arr))
                                       class="praise active"
                                       @else
                                       class="praise "
                                            @endif

                                    >赞 <span>{{ $dynamic->content->zan }}</span></a>
                                    {{--<a href="javascript:;"  class="praise ">
                                        赞<span>{{ $dynamic->content->zan }}</span>
                                    </a>--}}
                                    <div class="shared-tips shared-tips-bbs" style="display:none">
                                        <a href="javascript:;" class="shared-sina" data-cmd="tsina"><span></span>新浪微博</a>
                                        <a href="javascript:;" class="shared-weixin" data-cmd="weixin"><span></span>微信</a>
                                        <a href="javascript:;" class="shared-qzone" data-cmd="qzone"><span></span>QQ空间</a>
                                        <a href="javascript:;" class="shared-qq" data-cmd="tqq"><span></span>腾讯微博</a>
                                        <i class="arrows"></i>
                                    </div>

                                </div>

                            @endif

                    </li>
                    @endforeach
                    {{ $dynamics->render() }}
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
            </div>
            <!-- ./ box-left -->
            <!-- box-right -->
            <div class="box-right">
                <div class="panel-box user-interact clearfix" style="width: 250px">
                    <div class="attentions">
                        <a href="{{ URL('profile_faf') }}/{{ $user_info->id }}/1">
                            <div class="action-type">关注</div>
                            <div class="action-number">{{ $user_info->focus_num }}</div>
                        </a>
                    </div>
                    <div class="line"></div>
                    <div class="fans">
                        <a href="{{ URL('profile_faf') }}/{{ $user_info->id }}/2">
                            <div class="action-type">粉丝</div>
                            <div class="action-number">{{ $user_info->fans_num }}</div>
                        </a>
                    </div>

                </div>
                <div class="division"></div>
                <div class="panel-box user-information-box">
                    <div class="introduce"><h6>个性签名</h6><p><?php echo strip_tags($user_info->description) ?></p></div>
                    <div class="line"></div>
                    <ul class="main_info">
                        <li class="content">性别：<span>{{ $user_info->sex==1?'男':($user_info->sex==2?'女':'保密') }}</span></li>
                        <li class="line"></li>
                        <li class="content">生日： <span>{{ $user_info->birthday！!=0?:'保密' }}</span></li>
                        <li class="line"></li>
                        <li class="content">所在城市： <span>{{ $user_info->province.'-'.$user_info->city }}</span></li>
                        <li class="line"></li>
                        <li class="content">职业：<span></span></li>
                        <li class="line"></li>
                        <li class="content">教育背景：<span></span></li>
                        <li class="line"></li>

                    </ul>
                    <div class="tool">

                        <span class="lock-user">拉黑此人</span>
                    </div>
                </div>
                <div class="division"></div>
                <!-- recommend-big-view -->

                <!-- ./ left-recommend -->
                <div class="division"></div>
                <!-- hot-topic -->
                <!-- ./ hot-topic -->
                <div class="division"></div>
                <!-- recommend-remain-big-view -->
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
    </div>
    <script>

        /*$('.user-avatar').onmouseover(function () {

        })*/
    </script>

@endsection
