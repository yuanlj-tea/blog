<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use JWTAuth;
use JWTFactory;

class ApiController extends Controller
{
    /*登陆*/
    public function login(Request $request)
    {
        $userInfo = User::where('user_name','admin')->first();

        $userInfo->id =1;
        $token = JWTAuth::fromUser($userInfo);

        dd($token);

//        $customClaims = ['foo' => 'bar', 'baz' => 'bob','user_id'=>1];
//
//        $payload = JWTFactory::make($customClaims);
//
//        $token = JWTAuth::encode($payload);


        dd($token);
    }

    public function get_user_details()
    {
        
    }


}
