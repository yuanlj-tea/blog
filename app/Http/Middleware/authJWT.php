<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class authJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['user_not_found'], 404);
        }



//        try {
            //dd($request->input('token'));
            // 如果用户登陆后的所有请求没有jwt的token抛出异常
            //$user = JWTAuth::toUser($request->input('token'));


        //$token = JWTAuth::getToken();dd($token);

            // this will set the token on the object
            JWTAuth::parseToken();// and you can continue to chain methods

            $user = JWTAuth::parseToken()->attempt();
            dd($user);
//        } catch (Exception $e) {
//            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
//                return response()->json(['error'=>'Token 无效']);
//            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
//                return response()->json(['error'=>'Token 已过期']);
//            }else{
//                return response()->json(['error'=>'出错了']);
//            }
//        }
        return $next($request);
    }
}
