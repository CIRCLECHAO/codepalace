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
                            @if($type==1)
                            class="active"
                            @endif
                            id="dynamic-li"><a href="{{ URL('profile_faf') }}/{{ $user_info->id }}/1">全部关注&nbsp;{{ $user_info->focus_num }}</a></li>
                    <li
                            @if($type==2)
                            class="active"
                            @endif
                            id="dynamic-li"><a href="{{ URL('profile_faf') }}/{{ $user_info->id }}/2">全部粉丝&nbsp;{{ $user_info->fans_num }}</a></li>
                </ul>

                <div class="line"></div>
                <ul class="article-list dynamic-list">

                    @foreach($user_f_list as $user)
                    <li class="pt14 pl4">
                                <div class="user-box user-info-box">
                                    <div class="user-avatar user-info-lay popup-user" onmouseover="show_info(this)" onmouseleave="hide_info(this)">
                                        <img alt="" src="{{ $user->avatar }}" style="cursor: pointer;">
                                        <div class="popup-user-box" style="
                                                display: none;
                                                background-image: url('{{ $user->card_background_image }}');
                                                background-repeat: no-repeat;
                                                background-size:cover;">
                                            <div class="icon"></div>
                                            <div class="user-info-top">
                                                <div class="user-info-main clearfix">
                                                    <div class="user-photo">
                                                        <img src="{{ $user->avatar
                                                 }}" style="cursor: pointer;"></div>
                                                    <div class="user-main">
                                                        <div class="user-nick">
                                                            <a href="{{URL('profile')}}/{{ $user->id }}" target="_blank">{{ $user->name }}</a>
                                                        </div>
                                                        <div class="user-other"><p><?php echo strip_tags($user->description) ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="user-info-interact clearfix">
                                                        <div class="box"><span>发帖</span><span>{{ $user->article_num }}</span></div>
                                                        <div class="line"></div>
                                                        <div class="box"><span>评论</span><span>{{ $user->comment_num }}</span></div>
                                                        <div class="line"></div><div class="box"><span>粉丝</span><span>{{ $user->fans_num??0 }}</span></div>
                                                    </div></div></div><div class="user-info-bottom clearfix">
                                                <div class="attention pay-attention" data-id="{{ $user->id }}">
                                                    @if(in_array($user->id,$user_focus_arr))
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
                                        <h4><a href="{{URL('profile')}}/{{ $user->id }}" target="_blank">{{ $user->name }}</a></h4>
                                        <p><?php echo ($user->description) ?></p>
                                    </div>
                                </div>
                                <ul class="statistics clearfix">
                                    <li>粉丝<span>{{ $user->fans_num }}</span></li>
                                    <li>关注<span>{{ $user->focus_num }}</span></li>
                                    <li>文章<span>{{ $user->article_num }}</span></li>
                                </ul>

                    </li>
                    @endforeach
                    @if(count($user_f_list)>0)
                    {{ $user_f_list->render() }}
                        @endif
                </ul>
            </div>
            <!-- ./ box-left -->
            <!-- box-right -->
            <div class="box-right">
                <div class="panel-box user-interact clearfix" style="width: 250px">
                    <div class="attentions">
                        <a href="">
                            <div class="action-type">关注</div>
                            <div class="action-number">{{ $user_info->focus_num }}</div>
                        </a>
                    </div>
                    <div class="line"></div>
                    <div class="fans">
                        <a href="">
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
