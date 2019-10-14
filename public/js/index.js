/*
function getIndexOrder(){
    var theRequest = new Object();
    url = window.location.search;
    if (url.indexOf("?") != -1) {
        var str = url.substr(1);
        strs = str.split("&");
        for(var i = 0; i < strs.length; i ++) {
            theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]);
        }
    }

    if(theRequest['order']==undefined){
        return false;
    }else{
        return theRequest['order'];
    }
}

(function() {
    var my = {
        //当前排序
        order: 2,
        //获取数据
        getList:function(obj){
            //如果是已关注 先检查登录状态
            var indexUrl = '/main/index';
            if(my.order == 4){
                if(typeof isLogin !='undefined' && isLogin == true){
                    if(mylib.getUserDataByCookie()){
                        var userData = mylib.getUserDataByCookie();
                        var uid = userData[0];
                        indexUrl = indexUrl + '?uid=' + uid;
                    }
                }
            }

            var page = obj.data('page');//页码
            console.log('page1',page);
            //正在加载
            if(page == 1) mylib.loading(true);
            $.get(indexUrl,{page:page,order:my.order},function(res){
                if(page==1) mylib.loading(false);//关闭loading

                if($.trim(res) ==''){
                    obj.text('没有更多数据了');
                    return;
                }
                if(obj.hasClass('disabled')) obj.removeClass('disabled');
                switch(my.order){
                    case 1:
                        $('.orderby-last-comment').append(res);
                        break;
                    case 2:
                        $('.orderby-last-publish').append(res);
                        break;
                    case 3:
                        $('.orderby-24-hot').append(res);
                        break;
                    case 4:
                        $('.orderby-my-attention').append(res);
                        break;
                    case 5:
                        $('.orderby-big-view').append(res);
                        break;
                    case 6:
                        $('.orderby-3-day-hot').append(res);
                        break;
                    case 7:
                        $('.orderby-7-day-hot').append(res);
                        break;
                    case 8:
                        $('.orderby-3-month-hot').append(res);
                        break;
                }

                obj.text('加载更多');

                //设置页码
                obj.data('page',(page+1));
            });
        },
        //初始化
        init:function(){

            //加载更多
            $('.add-more').click(function(){
                if($(this).hasClass('disabled')) return;
                $(this).addClass('disabled');//加载数据前先禁用
                my.getList($(this));
            });

            //切换排序
            $('.order-control > ul > li').click(function(){
                var self = $(this);

                if(self.hasClass('active')) return;

                //移除其它状态
                self.siblings().each(function(){
                    if($(this).hasClass('active')) $(this).removeClass('active');
                });

                self.addClass('active');

                my.order = self.data('value');
                mylib.setCookie('index-list-order', my.order, '/');	//将order值记录进cookie
                //按钮控制
                $('.add-more').each(function(){
                    if($(this).hasClass('active')) $(this).removeClass('active');
                });

                //列表控制
                $('.article-list').each(function(){
                    if($(this).hasClass('active')) $(this).removeClass('active');
                });

                //列表显示
                var index = parseInt(self.data('value')) - 1;

                var currList = $('.article-list').eq(index);
                currList.addClass('active');

                //当前页码
                var currBtn = $('.add-more').eq(index);
                currBtn.addClass('active');
                var page = currBtn.data('page');
                console.log('page',page);
                if(page == 1){
                    my.getList(currBtn);
                }
            });
            var dropdownOutIndex;
            //当鼠标悬停在最后一个选项卡上的时候
            $('.order-control > ul >li:last').mouseover(function(){
                clearTimeout(dropdownOutIndex);
                var top = $(this).position().top;
                var left = $(this).position().left;
                $('.order-control-drop-down').css({'left' : left -20, 'top' : top + 38});
                $(this).next('ul').show();

            });
            $('body').on('mouseleave', '.order-control > ul >li:last', function(){
                clearTimeout(dropdownOutIndex);
                dropdownOutIndex = setTimeout(function(){
                    $('.order-control-drop-down').hide();
                },500);
            });

            //鼠标在下拉菜单上移动菜单变色
            $('body').on('mouseover', '.order-control-drop-down li', function(){
                clearTimeout(dropdownOutIndex);
                $(this).siblings().css('background-color', '#fff');
                $(this).css('background-color', '#f2f2f2');
            });
            //点击菜单
            $('body').on('click', '.order-control-drop-down li', function(){
                var self = $(this);
                var last = $('.order-control > ul >li:last');
                my.order = $(this).data('value');
                mylib.setCookie('index-list-order', my.order, '/');	//将order值记录进cookie
                var txt = $(this).text();
                $(this).parent().hide();
                last.html(txt + '最热' + '<i class="arrow-down"></i>');

                $('.order-control > ul > li').removeClass('active');
                $('.order-control > ul > li:last').addClass('active');
                //列表控制
                $('.article-list').each(function(){
                    if($(this).hasClass('active')) $(this).removeClass('active');
                });
                //按钮控制
                $('.add-more').each(function(){
                    if($(this).hasClass('active')) $(this).removeClass('active');
                });
                var index = parseInt(self.data('value')) -1;
                //列表显示
                var currList = $('.article-list').eq(index);
                currList.addClass('active');

                //当前页码
                var currBtn = $('.add-more').eq(index);
                currBtn.addClass('active');
                var page = currBtn.data('page');
                console.log('page',page);
                if(page == 1){
                    my.getList(currBtn);
                }
            });
            $('body').on('mouseleave', '.order-control-drop-down', function(){
                var that = this;
                clearTimeout(dropdownOutIndex);
                dropdownOutIndex = setTimeout(function(){
                    $(that).hide();
                },500);

            });


            //从cookie中读取数据切换列表
            var indexListOrder = mylib.getCookie('index-list-order');
            if(indexListOrder){
                indexListOrder = parseInt(indexListOrder);
                _indexListOrder = getIndexOrder();
                if(_indexListOrder) indexListOrder = parseInt(_indexListOrder);
                switch(indexListOrder){
                    case 1:
                        $('#orderby-last-comment').click();
                        break;
                    case 2:
                        $('#orderby-last-publish').click();
                        break;
                    case 3:
                        $('#orderby-24-hot').click();
                        break;
                    case 4:
                        $('#orderby-my-attention').click();
                        break;
                    case 5:
                        $('#orderby-big-view').click();
                        break;
                    case 6:
                        $('#orderby-3-day-hot').click();
                        break;
                    case 7:
                        $('#orderby-7-day-hot').click();
                        break;
                    case 8:
                        $('#orderby-3-month-hot').click();
                        break;
                }
            }
        },
    };

    my.init();

    //点击收藏
    var opTools = $('.article-list').find('.op-tools');
    var collectButtons = $('.article-list').find('.op-tools').find('a').eq(2); //收藏
    var praiseButtons = $('.article-list').find('.op-tools').find('a').eq(4); //赞

    //绑定点击收藏事件
    $('.article-list').on('click', '.collection', function(event) {
        //文章的收藏

        var codeType = $(this).attr('data-type');
        var codeId = $(this).attr('data-id');
        mylib.collect(codeId, codeType, 1, this);
        return false;

    });
    //绑定点击点赞事件
    $('.article-list').on('click', '.praise', function(event) {
        var postId = $(this).attr('data-id');
        mylib.praise(postId, this);
        return false;
    });

    $('.fw-affair').on('click', '.praise', function(event) {
        var postId = $(this).attr('data-id');
        mylib.praise(postId, this);
        return false;
    });


    //下拉自动加载更多
  /!*  $(window).scroll(function () {
        var btn = $('.add-more.active');
        //滚动加载更多
        if($(document).scrollTop() > (btn.offset().top - $(window).height()-200)) {
            if(!btn.hasClass('disabled')){
                btn.click();
            }
        }
    });*!/

    //热评点赞

    var URL = mylib.getUrl('user');//接口域名
    var API_CMT_PRAISE = URL + '/comment/praise'; //赞
    var cmt = {
        //POST
        post:function(url,data,fn){
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                xhrFields: {withCredentials: true},
                data: data,
                success : function(res){
                    fn(res);
                },
            });
        },


    };
    //赞
    $('.fw-hot-comments').on('click','.praise-nums',function(){

        if(!mylib.checkLogin()){
            return false;
        }
        var self = $(this);
        var cmtId = self.data('id');
        var data = {id:cmtId};
        cmt.post(API_CMT_PRAISE,data,function(res){
            var num = self.children('span').text();//当前点击数
            num = parseInt(num);
            if(res.code == 203){
                isLogin = false;
                mylib.checkLogin();
                return false;
            }else if(res.code == 0){
                if(self.hasClass('active')){
                    num = num -1;
                    self.children('span').text(num);
                    self.removeClass('active');
                }else{
                    num = num + 1;
                    self.children('span').text(num);
                    self.addClass('active');
                }
            }
        });
    });
})();*/
/*tab切换*/
/*$('.orderby-button').click(function () {
    if(!$(this).hasClass('active')){
        $(this).attr('class','orderby-button active');
        $(this).siblings().attr('class','orderby-button')
    }
})*/

