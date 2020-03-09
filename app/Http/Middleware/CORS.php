<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class CORS
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
        $allow_url = explode(',', env('all_cors_login_url'));

        $allowCorsPath = [
            'api/jwt/login'
        ];

        $requestPath = urldecode($request->path());
        $response = $next($request);
        if (in_array($requestPath, $allowCorsPath) && in_array($origin, $allow_url)) {
            $response->header('Access-Control-Allow-Origin', $origin);
            $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, Accept,Authorization,X-Requested-With,foo');
            $response->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT , X-CSRF-TOKEN');
            $response->header('Access-Control-Allow-Credentials', 'true');
            $response->header('Access-Control-Max-Age', 1728000);
            if($request->isMethod('options')){
                //laravel已经对options请求做了统一响应处理(状态码:200,响应内容:空字符串),此处添加响应内容:ok
                $response->setStatusCode(200);
                return $response->setContent('ok');
            }
            return $response;
        } elseif (Str::contains($requestPath, $allowCorsPath) && in_array('header', get_class_methods(get_class($response)))) {
            $response->header('Access-Control-Allow-Origin', '*');
            $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, Accept');
            $response->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS,X-CSRF-TOKEN');
            $response->header('Access-Control-Allow-Credentials', 'true');
            return $response;
        }

        return $response;
    }
}
