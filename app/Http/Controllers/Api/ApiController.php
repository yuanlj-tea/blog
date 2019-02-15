<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use JWTAuth;
use JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;

class ApiController extends Controller
{
    /*登陆*/
    public function login(Request $request)
    {
        $userInfo = User::where('user_name', 'admin')->first();

        //$userInfo->id =1;
        $token = JWTAuth::fromUser($userInfo);

        dd($token);
    }


    public function get_user_details()
    {

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
        /*$userInfo = User::where('user_name', 'admin')->first();
        $token = JWTAuth::fromUser($userInfo);

        dd($token);*/

        //3、基于任意数据创建token
        $customClaims = ['foo' => 'bar', 'baz' => 'bob', 'user_id' => 1];

        $payload = JWTFactory::make($customClaims);

        $token = JWTAuth::encode($payload);
        dump($token);
        dd((string)$token);
    }


}
