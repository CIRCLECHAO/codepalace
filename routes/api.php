<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function (Request $request) {
    return 'test';
});

Route::get('/index/{category?}/{type?}/{keyword?}', 'Api\ApiController@index')->where(['category'=>'[0-9]+','type'=>'[0-9]+']);

Route::get('/article_detail/{id?}', 'Api\ApiController@article_detail')->where(['id'=>'[0-9]+']);


Route::post('/common/', 'Api\ApiController@common');


