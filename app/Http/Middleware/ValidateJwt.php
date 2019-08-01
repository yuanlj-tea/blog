<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use App\Libs\Response;
use RedisPHP;

class ValidateJwt
{
    const KEY = '1gHuiop975cdashyex9Ud23ldsvm2Xq';

    /**
     * 登录过期时长
     * @var float|int
     */
    public $loginExpTime;

    /**
     * token黑名单
     * @var string
     */
    public $tokenBlackList = 'token_blacklist_';

    public function __construct()
    {
        //设置登录过期时长为8小时
        $this->loginExpTime = 8 * 3600;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $newJwt = null;
        $jwt = $request->input('jwt', '');
        $jwt = !empty($jwt) ? $jwt : ($request->header('x-token', ''));

        //缺少jwt token
        if (empty($jwt)) {
            return Response::fail('缺少jwt token');
        }
        try {
            Jwt::$leeway = 60;
            $decoded = Jwt::decode($jwt, self::KEY, ['HS256']);
            $decoded = (array)$decoded;

            //登录过期验证 todo:跳转到登录页面
            if (time() - $decoded['iat'] > $this->loginExpTime) {
                return Response::fail('登录过期，请重新登录');
            }

        } catch (ExpiredException $e) {
            try {
                //token过期，刷新token，自动续签
                //如果redis token黑名单中存在该token，不刷新token，用黑名单对应的新token
                $blackListNewJwt = RedisPHP::get($this->tokenBlackList . $jwt);
                $newJwt = !empty($blackListNewJwt)
                    ? $blackListNewJwt
                    : Jwt::refreshToken($jwt, self::KEY, ['HS256']);

                //更改请求头为新的jwt token
                $request->headers->set('x-token', $newJwt);

                //黑名单中不存在，则将旧token存到redis中；60秒有效期，60秒内的过期的token的请求是有效的
                if (empty($blackListNewJwt)) {
                    RedisPHP::setex($this->tokenBlackList . $jwt, 60, $newJwt);
                } else {
                    //放行
                    return $next($request);
                }
            } catch (\Exception $e) {
                return Response::fail($e->getMessage());
            }

        } catch (\Exception $e) {
            return Response::fail($e->getMessage());
        }

        $response =  $next($request);
        //如果有新token，就在响应头添加新的jwt token
        if($newJwt){
            $response->headers->set('x-token',$newJwt);
        }
        return $response;
    }
}
