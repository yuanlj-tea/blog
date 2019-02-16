<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use AjaxResponse;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Redis;

class authJWT
{
    /**
     * token黑名单
     * @var string
     */
    protected $tokenBlackList = 'tymon_token_black_list_';

    /**
     * 黑名单中的token过期时间
     * @var int
     */
    protected $blackExpTime = 30;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $newToken = null;
        //获取客户端传递的token
        if (!$token = JWTAuth::getToken()) {
            return AjaxResponse::fail('缺少token参数');
        }
        $token = (string)$token;

        try {
            //解析token
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return AjaxResponse::fail('未找到用户信息');
            }

        } catch (TokenInvalidException $e) {
            return AjaxResponse::fail('无效的token');
        } catch (TokenExpiredException $e) {
            try {
                //token过期，自动续签
                $blackListNewToken = Redis::get($this->tokenBlackList . $token);
                $newToken = !empty($blackListNewToken) ? $blackListNewToken : JWTAuth::refresh($token);

                //更改请求头为新的token
                $request->headers->set('Authorization', 'Bearer ' . $newToken);

                //过期的token在黑名单中不存在，则存入redis中；10秒钟有效期，10秒内过期的token的请求是有效的
                if (empty($blackListNewToken)) {
                    Redis::setex($this->tokenBlackList . $token, $this->blackExpTime, $newToken);
                } else {
                    //如果有新token，添加响应头，自动续签token(前端判断响应头有该数据，自动更换local storage里的token)
                    $response = $next($request);
                    /*if ($newToken) {
                        $response->headers->set('Access-Control-Expose-Headers', 'Authorization');
                        $response->headers->set('Authorization', 'Bearer ' . $newToken);
                    }*/
                    return $response;
                }

            } catch (TokenBlacklistedException $e) {
                return AjaxResponse::fail('token已被加入黑名单');
            } catch (JWTException $e) {
                //todo 跳转到登录页面
                return AjaxResponse::fail('登录已过期，请重新登录');
            }
        } catch (\Exception $e) {
            return AjaxResponse::fail(sprintf(
                "【FILE】：%s；【LINE】：%s；【MSG】：%s",
                $e->getFile(),
                $e->getLine(),
                $e->getMessage()
            ));
        }

        $response = $next($request);
        //如果有新token，添加响应头，自动续签token(前端判断响应头有该数据，自动更换local storage里的token)
        if ($newToken) {
            $response->headers->set('Access-Control-Expose-Headers', 'Authorization');
            $response->headers->set('Authorization', 'Bearer ' . $newToken);
        }
        return $response;
    }
}
