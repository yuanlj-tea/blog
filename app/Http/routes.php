<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::group(['middleware' => ['web']], function () {

    Route::get('/', 'Home\IndexController@index');
    Route::get('/testStreamPdf', 'Home\IndexController@testStreamPdf');
    Route::get('/testDownloadPdf', 'Home\IndexController@testDownloadPdf');
    Route::any('/savePic', 'Home\IndexController@savePic');
    Route::get('/cate/{cate_id}', 'Home\IndexController@cate');
    Route::get('/a/{art_id}', 'Home\IndexController@article');

    Route::any('admin/login', 'Admin\LoginController@login');
    Route::get('admin/code', 'Admin\LoginController@code');
});


Route::group(['middleware' => ['web', 'admin.login'], 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('index', 'IndexController@index');
    Route::get('info', 'IndexController@info');
    Route::get('quit', 'LoginController@quit');
    Route::any('pass', 'IndexController@pass');

    Route::post('cate/changeorder', 'CategoryController@changeOrder');
    Route::resource('category', 'CategoryController');

    Route::resource('article', 'ArticleController');

    Route::post('links/changeorder', 'LinksController@changeOrder');
    Route::resource('links', 'LinksController');

    Route::post('navs/changeorder', 'NavsController@changeOrder');
    Route::resource('navs', 'NavsController');

    Route::get('config/putfile', 'ConfigController@putFile');
    Route::post('config/changecontent', 'ConfigController@changeContent');
    Route::post('config/changeorder', 'ConfigController@changeOrder');
    Route::resource('config', 'ConfigController');

    Route::any('upload', 'CommonController@upload');

});


Route::get('vaptcha/challenge', 'VaptchaController@getChallenge');
Route::get('vaptcha/downtime', 'VaptchaController@getDownTime');
Route::get('vaptcha/vaptchaView', 'VaptchaController@vaptchaView');

Route::get('/test', 'Home\IndexController@test');
Route::get('/qrCode', 'Home\IndexController@qrCode');

Route::group(['prefix' => 'swagger'], function () {
    Route::any('/getJson', 'SwaggerController@getJson');
    Route::any('/my-data', 'SwaggerController@getMyData');
    Route::any('/getMyData1', 'SwaggerController@getMyData1');
});

// jwt token
Route::group(['middleware' => ['api', 'cors'], 'prefix' => 'api/jwt','namespace' => 'Api'], function () {
    Route::any('register', 'ApiController@register');     // 注册
    Route::any('login', 'ApiController@login');           // 登陆
    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::any('get_user_details', 'ApiController@get_user_details');  // 获取用户详情
    });
});


Route::group(['namespace' => 'Home','prefix'=>'api'], function () {
    Route::any('index', 'TestJwt@index');    
    Route::any('login', 'TestJwt@login');    
    
});