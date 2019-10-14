<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//
Auth::routes();
/*-------------------------------前台路由--------------------------------------------------*/
/*登录路由*/
Route::post('/login','Auth\WebLoginController@login');
/*注册路由*/
Route::post('/register','Auth\WebRegisterController@register');

/*抹除之前的路由*/
Route::get('/login','Auth\LoginController@loginremove');
Route::get('/register','Auth\LoginController@registerremove');

/*论坛首页*/
Route::get('/{category?}/{type?}/{keyword?}', 'Home\HomeController@index')->where(['category'=>'[0-9]+','type'=>'[0-9]+']);

//添加帖子页面
Route::get('add_article','Article\ArticleController@index');
//添加帖子接口
Route::post('save_article','Article\ArticleController@add_article');

//帖子详情
Route::get('article_show/{id}','Home\HomeController@article_show')->where('id','[0-9]+');

//点赞 去掉赞
Route::post('article_zan','Article\ArticleController@zan_article');

//收藏 取消收藏
Route::post('article_collect','Article\ArticleController@collect_article');


//添加评论
Route::post('user/comments','User\ArticleController@add_comment');


//个人信息完善页面
Route::get('/user/settings','User\SettingController@get_settings');
//保存个人信息
Route::post('/user/save_settings','User\SettingController@save_settings');
//个人主页
Route::get('profile/{id}/{type?}','User\SettingController@show_info')->where(['id'=>'[0-9]+','type'=>'[0-9]+']);

/*关注以及粉丝列表页*/
Route::get('profile_faf/{id}/{type}','User\SettingController@show_faf')->where(['id'=>'[0-9]+','type'=>'[0-9]+']);

/*QQ快捷登录*/
Route::get('/qq_login{code?}','Auth\QQLoginController@qq_login');
Route::get('/qq','Auth\QQLoginController@qq');

/*意见反馈*/
Route::get('/suggestion/{my?}','Suggestion\SuggestionController@index');
Route::get('/add_suggestion','Suggestion\SuggestionController@add');
Route::post('/save_suggestion','Suggestion\SuggestionController@save');
Route::get('/suggestion_detail/{id}','Suggestion\SuggestionController@detail')->where('id','[0-9]+');

/*关注 取关动作*/
Route::post('user/change_focus','User\SettingController@change_focus');

/*获取关注或者粉丝*/
Route::post('user/get_focus','User\SettingController@get_focus');

/*获取行政区域*/
Route::post('/get_geography_info',
            'Geography\GeographyController@get_gs_info');
/*图片上传工具*/
Route::post('/image_upload','Tool\ToolController@upload_image');

/*网页聊天*/
//获取用户列表
Route::post('/get_userlist','Home\UserController@get_user_list');
//获取聊天记录
Route::post('/get_chatrecord','Chat\ChatController@get_chat_record');
//保存会话内容
Route::post('/add_chat','Chat\ChatController@add_chat');
//设置消息已读
Route::post('/set_read','Chat\ChatController@set_read');

//获取未读总数
Route::post('/get_unread_num','Controller@get_unread_num');


//--------------------------------------测试用--------------------------------//
Route::get('/test','Test\TestController@test');
/*socket开启*/
Route::match(['get', 'post'],'/testsocket','Test\TestWebsocketController@test');
/*绑定*/
Route::match(['get', 'post'],'/testbind','Test\TestWebsocketController@bind');
/*发送信息*/
Route::match(['get', 'post'],'/testsend/{uid?}/{message?}','Test\TestWebsocketController@send_message');