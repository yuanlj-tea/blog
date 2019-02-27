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
Route::get('/check', 'Home\IndexController@check');

// test swagger
Route::group(['prefix' => 'swagger'], function () {
    Route::any('/getJson', 'SwaggerController@getJson');
    Route::any('/my-data', 'SwaggerController@getMyData');
    Route::any('/getMyData1', 'SwaggerController@getMyData1');
});

// jwt token(tymon)
Route::group(['prefix' => 'api/jwt','namespace' => 'Api'], function () {
    // 登陆
    Route::any('login', 'ApiController@login');
    // 测试jwt生成的方式
    Route::any('test', 'ApiController@test');
    //刷新token
    Route::any('refreshToken','ApiController@refreshToken');
    Route::group(['middleware' => 'jwt.auth'], function () {
        // 获取用户详情
        Route::any('getUserDetails', 'ApiController@getUserDetails');
    });
});


// test common jwt(firebase)
Route::group(['namespace' => 'Home', 'prefix' => 'api'], function () {
    Route::get('index', 'TestJwt@index');
    Route::any('login', 'TestJwt@login');

    Route::group(['middleware' => 'validate-jwt'],function(){
        Route::any('getUserInfo','TestJwt@getUserInfo');

    });
});

// test es
Route::group(['namespace' => 'Home','prefix'=>'es'], function () {
    Route::any('initIndex', 'EsController@initIndex');
    Route::any('search', 'EsController@search');
    Route::any('searchArticle', 'EsController@searchArticle');

});


//用户授权
Route::group(['prefix' => 'oauth','middleware' => 'oauth-exception'], function () {
    //grant type: authorization code GET
    Route::get('authorize', ['as' => 'oauth.authorize.get', 'middleware' => ['check-authorization-params'], 'uses' => 'OAuthController@newAuthorize']);

    //grant type: authorization code POST
    Route::post('authorize', ['as' => 'oauth.authorize.post', 'middleware' => [ 'check-authorization-params'], 'uses' => 'OAuthController@newAuthorize']);

    //获取 access_token
    Route::any('access_token', ['as' => 'access_token', 'uses' => 'OAuthController@accessToken']);

    //获取用户信息
    Route::get('user_info', ['middleware' => ['oauth'], 'uses' => 'OAuthController@userInfo']);
});
//成功授权后的跳转地址
Route::get('oauth/callback','OAuthController@callback');

//测试guzzle http请求
Route::group(['namespace'=>'Home','prefix'=>'guzzle'],function(){
    Route::get('testGuzzle','IndexController@testGuzzle');
});

//SSO相关
Route::group(['namespace'=>'SSO','prefix'=>'sso'],function(){
    //SSO-SERVER相关
    Route::group(['prefix'=>'server'],function(){
        //登录
        Route::any('/login','SsoServer@login');
        //验证token
        Route::any('/validateToken',['middleware'=>['validate-signature'],'uses'=>'SsoServer@validateToken']);
        //退出登录
        Route::any('/logout',['middleware'=>['validate-signature'],'uses'=>'SsoServer@logout']);

    });
    //单站点相关
    Route::group(['prefix'=>'site_a'],function(){
        //单站点验证是否已登录
        Route::any('/checkIsLogin','SiteA@checkIsLogin');
        //单站点回调地址
        Route::any('/redirectUrl','siteA@redirectUrl');
        //单点注销登录
        Route::any('/logout',['middleware'=>['validate-signature'],'uses'=>'siteA@logout']);
        //单站点，浏览器端点击退出登录调用接口
        Route::any('/browserLogout','siteA@browserLogout');
    });
});
