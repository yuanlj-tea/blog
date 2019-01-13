<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use AjaxResponse;

class authJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

//        $jwt = isset($_SERVER['HTTP_X_TOKEN']) ? $_SERVER['HTTP_X_TOKEN'] : '';
//
//        $user = JWTAuth::toUser($jwt);
//        dd($user);

        //        $token = JWTAuth::getToken();

        //this will set the token on the object
//            $res = JWTAuth::parseToken();// and you can continue to chain methods
//
//             $user = JWTAuth::parseToken()->attempt();
//             dd($user);

        // 如果用户登陆后的所有请求没有jwt的token抛出异常
//        $user = JWTAuth::toUser($request->input('token', ''));


        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            dd($user);
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return AjaxResponse::fail('无效的token');
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return AjaxResponse::fail('token已过期');
            } else {
                return AjaxResponse::fail('出错了');
            }
        }
        return $next($request);
    }
}
