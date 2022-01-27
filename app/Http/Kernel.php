<?php

namespace App\Http;

use App\Http\Middleware\CustomThrottleRequests;
use App\Http\Middleware\TokenBucketRatelimit;
use App\Http\Middleware\TraceMiddleware;
use App\Http\Middleware\ValidateSignature;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\Cors::class, //由于laravel对options请求做了特殊处理(统一返回200状态码,不添加cors响应头),在此全局中间件处添加统一cors中间件,添加响应头

        //OAuth2 Server
        // \LucaDegasperi\OAuth2Server\Middleware\OAuthExceptionHandlerMiddleware::class,
        // \App\HtaDegasperi\OAuth2Server\Middleware\OAuthExceptionHandlerMiddleware::class,
        // \App\Http\Middleware\OAuthExceptionHandlerMiddleware::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \App\Http\Middleware\Cors::class,
        ],

        'api' => [
            'throttle:60,1',
        ],
        'api_v1' => [
            'throttle.custom:2,1'
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'throttle.custom' => CustomThrottleRequests::class,
        'admin.login' => \App\Http\Middleware\AdminLogin::class,
        'cors' => \App\Http\Middleware\CORS::class,
        'my-jwt.auth' => \App\Http\Middleware\authJWT::class,

        // OAuth2 Server
        'oauth' => \LucaDegasperi\OAuth2Server\Middleware\OAuthMiddleware::class,
        'oauth-user' => \LucaDegasperi\OAuth2Server\Middleware\OAuthUserOwnerMiddleware::class,
        'oauth-client' => \LucaDegasperi\OAuth2Server\Middleware\OAuthClientOwnerMiddleware::class,
        'check-authorization-params' => \LucaDegasperi\OAuth2Server\Middleware\CheckAuthCodeRequestMiddleware::class,
        'oauth-exception' => \App\Http\Middleware\OAuthExceptionHandlerMiddleware::class,

        // 验证jwt token
        'validate-jwt' => \App\Http\Middleware\ValidateJwt::class,
        //签名验证
        'validate-signature' => ValidateSignature::class,
        //自定义基于redis实现的令牌桶限流
        'token_bucket_rate_limit' => TokenBucketRatelimit::class,
        'trace' => TraceMiddleware::class,
    ];
}
