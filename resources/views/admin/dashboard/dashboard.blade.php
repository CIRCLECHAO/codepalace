<!-- Bootstrap CSS-->
<link rel="stylesheet" href="{{ asset('vendor/admin/bootstrap/css/bootstrap.min.css') }}">
<!-- Font Awesome CSS-->
<link rel="stylesheet" href="{{ asset('vendor/admin/font-awesome/css/font-awesome.min.css') }}">
<!-- Fontastic Custom icon font-->
<link rel="stylesheet" href="{{ asset('css/admin/fontastic.css') }}">
<!-- Google fonts - Poppins -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
<!-- theme stylesheet-->
<link rel="stylesheet" href="{{ asset('css/admin/style.default.css') }}" id="theme-stylesheet">
<!-- Favicon-->
<link rel="shortcut icon" href="">
<!-- Tweaks for older IEs--><!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
<style>
    .navbar {
        padding: 0;
    }
    .nav:before, .navbar:before {
        content: none !important;
    }
    .nav:after, .navbar:after {
        content: none !important;
    }
</style>
<div class="page">
    <!-- Main Navbar-->
    <div class="page-content d-flex align-items-stretch">
        <!-- Side Navbar -->
        <div class="content-inner">
            <!-- Dashboard Counts Section-->
            <section class="dashboard-counts no-padding-bottom">
                <div class="container-fluid">
                    <div class="row bg-white has-shadow">
                        <!-- Item -->
                        <div class="col-xl-3 col-sm-6">
                            <div class="item d-flex align-items-center">
                                <div class="icon bg-violet"><i class="icon-user"></i></div>
                                <div class="title"><span>今日<br>访问人次</span>
                                    <div class="progress">
                                        <div role="progressbar"
                                             style="width: {{ $daily_data->read_num }}%; height: 4px;"
                                             aria-valuenow="{{ $daily_data->read_num??0 }}" aria-valuemin="0"
                                             aria-valuemax="100" class="progress-bar bg-violet"></div>
                                    </div>
                                </div>
                                <div class="number"><strong>{{ $daily_data->read_num??0 }}</strong></div>
                            </div>
                        </div>
                        <!-- Item -->
                        <div class="col-xl-3 col-sm-6">
                            <div class="item d-flex align-items-center">
                                <div class="icon bg-red"><i class="icon-padnote"></i></div>
                                <div class="title"><span>今日<br>登录人次</span>
                                    <div class="progress">
                                        <div role="progressbar"
                                             style="width: {{ $daily_data->login_num }}%; height: 4px;"
                                             aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"
                                             class="progress-bar bg-red"></div>
                                    </div>
                                </div>
                                <div class="number"><strong>{{ $daily_data->login_num??0 }}</strong></div>
                            </div>
                        </div>
                        <!-- Item -->
                        <div class="col-xl-3 col-sm-6">
                            <div class="item d-flex align-items-center">
                                <div class="icon bg-green"><i class="icon-bill"></i></div>
                                <div class="title"><span>今日<br>发表文章</span>
                                    <div class="progress">
                                        <div role="progressbar"
                                             style="width: {{ $daily_data->article_write_num }}%; height: 4px;"
                                             aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                                             class="progress-bar bg-green"></div>
                                    </div>
                                </div>
                                <div class="number"><strong>{{ $daily_data->article_write_num??0 }}</strong></div>
                            </div>
                        </div>
                        <!-- Item -->
                        <div class="col-xl-3 col-sm-6">
                            <div class="item d-flex align-items-center">
                                <div class="icon bg-orange"><i class="icon-check"></i></div>
                                <div class="title"><span>今日<br>新增评论</span>
                                    <div class="progress">
                                        <div role="progressbar"
                                             style="width: {{ $daily_data->comment_num??0 }}%; height: 4px;"
                                             aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
                                             class="progress-bar bg-orange"></div>
                                    </div>
                                </div>
                                <div class="number"><strong>{{ $daily_data->comment_num??0 }}</strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Dashboard Header Section    -->
            <section class="dashboard-header">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Statistics -->
                        <div class="statistics col-lg-3 col-12">
                            <div class="statistic d-flex align-items-center bg-white has-shadow">
                                <div class="icon bg-red"><i class="fa fa-tasks"></i></div>
                                <div class="text"><strong>{{ $max_click->click??0 }}</strong><br>
                                    <small>单文章最大点击量</small>
                                </div>
                            </div>
                            <div class="statistic d-flex align-items-center bg-white has-shadow">
                                <div class="icon bg-green"><i class="fa fa-calendar-o"></i></div>
                                <div class="text"><strong>{{ $max_comment->count??0 }}</strong><br>
                                    <small>单文章最大评论数</small>
                                </div>
                            </div>
                            <div class="statistic d-flex align-items-center bg-white has-shadow">
                                <div class="icon bg-orange"><i class="fa fa-paper-plane-o"></i></div>
                                <div class="text"><strong>{{ $max_article->count??0 }}</strong><br>
                                    <small>单作者最大文章数</small>
                                </div>
                            </div>
                        </div>
                        <!-- Line Chart-->
                        <div class="chart col-lg-6 col-12">
                            <div class="line-chart bg-white d-flex align-items-center justify-content-center has-shadow">
                                <canvas id="lineCahrt"></canvas>
                            </div>
                        </div>
                        <div class="chart col-lg-3 col-12">
                            <!-- Bar Chart   -->
                            <div class="bar-chart has-shadow bg-white">
                                <div class="title"><strong class="text-violet">趋势</strong><br>
                                    <small>每日发布文章数</small>
                                </div>
                                <canvas id="barChartHome"></canvas>
                            </div>
                            <!-- Numbers-->
                            <div class="statistic d-flex align-items-center bg-white has-shadow">
                                <div class="icon bg-green"><i class="fa fa-line-chart"></i></div>
                                <div class="text"><strong>{{ $read_percent }}</strong><br>
                                    <small>今日详情页、首页访问比</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="client no-padding-top">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Work Amount  -->
                        <div class="col-lg-4">
                            <div class="work-amount card">
                                <div class="card-close">
                                    <div class="dropdown">
                                        <button type="button" id="closeCard1" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i
                                                    class="fa fa-ellipsis-v"></i></button>
                                        <div aria-labelledby="closeCard1"
                                             class="dropdown-menu dropdown-menu-right has-shadow"><a href="#"
                                                                                                     class="dropdown-item remove">
                                                <i class="fa fa-times"></i>Close</a><a href="#"
                                                                                       class="dropdown-item edit"> <i
                                                        class="fa fa-gear"></i>Edit</a></div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h3>全站</h3>
                                    <small>文章类型占比</small>
                                    <div class="chart text-center">
                                        <div class="text"><strong>全部</strong><br><span>时间</span></div>
                                        <canvas id="pieChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Client Profile -->
                        <div class="col-lg-4">
                            <div class="client card">
                                <div class="card-close">
                                    <div class="dropdown">
                                        <button type="button" id="closeCard2" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i
                                                    class="fa fa-ellipsis-v"></i></button>
                                        <div aria-labelledby="closeCard2"
                                             class="dropdown-menu dropdown-menu-right has-shadow"><a href="#"
                                                                                                     class="dropdown-item remove">
                                                <i class="fa fa-times"></i>Close</a><a href="#"
                                                                                       class="dropdown-item edit"> <i
                                                        class="fa fa-gear"></i>Edit</a></div>
                                    </div>
                                </div>
                                <div class="card-body text-center">
                                    <div class="client-avatar"><img src="{{ asset($good_user->avatar) }}" alt="..." class="img-fluid rounded-circle">
                                        <div class="status bg-green"></div>
                                    </div>
                                    <div class="client-title">
                                        <h3>{{ $good_user->name }}</h3><span>{{ $good_user->description }}</span><a href="#">无用按钮</a>
                                    </div>
                                    <div class="client-info">
                                        <div class="row">
                                            <div class="col-4"><strong>{{ $good_user->article_num }}</strong><br>
                                                <small>发表文章</small>
                                            </div>
                                            <div class="col-4"><strong>{{ $good_user->be_commented_num }}</strong><br>
                                                <small>收到评论</small>
                                            </div>
                                            <div class="col-4"><strong>{{ $good_user->be_zan_num }}</strong><br>
                                                <small>收到点赞</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="client-social d-flex justify-content-between"><a href="#"
                                                                                                 target="_blank"><i
                                                    class="fa fa-facebook"></i></a><a href="#" target="_blank"><i
                                                    class="fa fa-twitter"></i></a><a href="#" target="_blank"><i
                                                    class="fa fa-google-plus"></i></a><a href="#" target="_blank"><i
                                                    class="fa fa-instagram"></i></a><a href="#" target="_blank"><i
                                                    class="fa fa-linkedin"></i></a></div>
                                </div>
                            </div>
                        </div>
                        <!-- Total Overdue             -->
                        <div class="col-lg-4">
                            <div class="overdue card">
                                <div class="card-close">
                                    <div class="dropdown">
                                        <button type="button" id="closeCard3" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i
                                                    class="fa fa-ellipsis-v"></i></button>
                                        <div aria-labelledby="closeCard3"
                                             class="dropdown-menu dropdown-menu-right has-shadow"><a href="#"
                                                                                                     class="dropdown-item remove">
                                                <i class="fa fa-times"></i>Close</a><a href="#"
                                                                                       class="dropdown-item edit"> <i
                                                        class="fa fa-gear"></i>Edit</a></div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h3>网页聊天系统数据</h3>
                                    <small>月统计数据</small>
                                    <div class="number text-center">共计：3600次</div>
                                    <div class="chart">
                                        <canvas id="lineChart1"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Feeds Section-->

        </div>
    </div>
</div>
<script>
    var zxt_data = '<?php echo $daily_list ?>';
    var pie_data = '<?php echo $article_datas_post ?>';
    console.log(pie_data);
</script>
<script src="{{ asset('vendor/admin/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/admin/popper.js/umd/popper.min.js') }}"></script>
<script src="{{ asset('vendor/admin/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendor/admin/jquery.cookie/jquery.cookie.js') }}"></script>
<script src="{{ asset('vendor/admin/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('vendor/admin/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/admin/charts-home.js') }}"></script>
<!-- Main File-->
<script src="{{ asset('js/admin/front.js') }}"></script>
