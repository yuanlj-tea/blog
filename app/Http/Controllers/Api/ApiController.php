<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\User;
use Elasticsearch\Serializers\ArrayToJSONSerializer;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use JWTAuth;
use JWTFactory;
use AjaxResponse;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

class ApiController extends Controller
{
    /**
     * 用户登录
     * @param Request $request
     */
    public function login(Request $request)
    {
        $user = xss_filter($request->input('user', ''));
        $pwd = xss_filter($request->input('pwd', ''));

        $user = User::where('user_name', $user)->first();
        if (!isset($user->user_id)) {
            return AjaxResponse::fail('无效的用户名');
        }
        if ($pwd != $user->user_pass) {
            return AjaxResponse::fail('密码错误');
        }
        try {
            $token = JWTAuth::fromUser($user);
            return AjaxResponse::success($token);
        } catch (\Exception $e) {
            return AjaxResponse::fail($e->getMessage());
        }
    }

    /**
     * 获取用户信息
     * @param Request $request
     */
    public function getUserDetails(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        return AjaxResponse::success($user);
    }

    public function refreshToken(Request $request)
    {
        $cookie = \Cookie::get('bdshare_firstime');p($cookie,1);
        $token = JWTAuth::getToken();
        if (empty($token)) {
            return AjaxResponse::fail('缺少token');
        }
        $token = (string)$token;


        try {
            $newToken = JWTAuth::refresh($token);
            return AjaxResponse::success([
                'oldToken' => $token,
                'newToken' => $newToken
            ]);
        } catch (TokenBlacklistedException $e) {
            return AjaxResponse::fail('已换取过一次token，该token已被加入黑名单');
        } catch (JWTException $e) {
            return AjaxResponse::fail($e->getMessage());
        }
    }

    /**
     * 测试jwt生成的方式
     */
    public function test(Request $request)
    {
        /*//1、grab credentials from the request
        $credentials = $request->only('user_name', 'user_pass','password');
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token','reason'=>$e->getMessage()], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));*/

        //2、从用户表创建token
        $userInfo = User::where('user_name', 'admin')->first();
        $token = JWTAuth::fromUser($userInfo);

        dd($token);

        //3、基于任意数据创建token
        /*$customClaims = ['foo' => 'bar', 'baz' => 'bob', 'user_id' => 1];

        $payload = JWTFactory::make($customClaims);

        $token = JWTAuth::encode($payload);
        dump($token);
        dd((string)$token);*/

        //解析token
        // $res = JWTAuth::parseToken();// and you can continue to chain methods
        $user = JWTAuth::parseToken()->authenticate();
        p($user, 1);

        //获取token
        $token = JWTAuth::getToken();
        dd($token);
    }


}
