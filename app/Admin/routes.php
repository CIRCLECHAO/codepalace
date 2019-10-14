<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    /*前台用户管理列表*/
    $router->get('/web/web_users', 'UserController@index');

    /*前台用户管理保存*/
    $router->put('/web/web_users/{id}', 'UserController@save')->where('id','[0-9]+');

    /*用户删除*/
    $router->delete('/web/web_users/{id}', 'UserController@delete')->where('id','[0-9]+');

    /*前台用户管理详情查看*/
    $router->get('/web/web_users/{id}', 'UserController@show')->where('id','[0-9]+');

    /*前台用户管理编辑*/
    $router->get('/web/web_users/{id}/edit', 'UserController@edit')->where('id','[0-9]+');



    /*前台文章管理列表*/
    $router->get('/web/web_articles', 'ArticleController@index');

    /*前台文章管理详情查看*/
    $router->get('/web/web_articles/{id}', 'ArticleController@show')->where('id','[0-9]+');

    /*前台文章管理审核*/
    $router->post('/web/web_articles/check', 'ArticleController@check')->where('id','[0-9]+');


    /*前台留言板管理列表*/
    $router->get('/web/web_suggestions', 'SuggestionController@index');

    /*前台留言板管理详情查看*/
    $router->get('/web/web_suggestions/{id}', 'SuggestionController@show')->where('id','[0-9]+');

    /*前台留言板处理*/
    $router->post('/web/web_suggestions/check', 'SuggestionController@check')->where('id','[0-9]+');

});
