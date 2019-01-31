<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;
use AjaxResponse;

class TestJwt extends Controller
{

    const KEY = '1gHuiop975cdashyex9Ud23ldsvm2Xq';

    public function index()
    {
        return view('home.test');
    }

    public function login(Request $request)
    {

        $res['result'] = 'failed';

        $action = $request->input('action', '');

        if ($action == 'login') {

            $username = htmlentities($request->input('user', ''));
            $password = htmlentities($request->input('pass', ''));

            if ($username == 'demo' && $password == 'demo') { //用户名和密码正确，则签发tokon
                $nowtime = time();
                $expLong = 10*60;
                $token = [
                    'iss' => 'http://www.helloweba.net', //签发者
                    'aud' => 'http://www.helloweba.net', //jwt所面向的用户
                    'iat' => $nowtime, //签发时间
                    'nbf' => $nowtime + 0, //在什么时间之后该jwt才可用
                    'exp' => $nowtime + $expLong, //过期时间:10min
                    'exp_long' => $expLong,
                    'data' => [
                        'userid' => 1,
                        'username' => $username
                    ]
                ];
                $jwt = JWT::encode($token, self::KEY);
                $res['result'] = 'success';
                $res['jwt'] = $jwt;
            } else {
                $res['msg'] = '用户名或密码错误!';
            }

            echo json_encode($res);

        } else {
            // p($request->headers,1);
            $jwt = $request->header('x-token','');
            if (empty($jwt)) {
                $res['msg'] = 'You do not have permission to access.';
                echo json_encode($res);
                exit;
            }

            try {
                JWT::$leeway = 60;
                $decoded = JWT::decode($jwt, self::KEY, ['HS256']);
                $arr = (array)$decoded;

                if ($arr['exp'] < time()) {
                    $res['msg'] = '请重新登录';
                } else {
                    $res['result'] = 'success';
                    $res['info'] = $arr;
                }
            } catch (ExpiredException $e) {
                $res['msg'] = 'token已过期';
            } catch (\Exception $e) {
                $res['msg'] = 'Token验证失败,请重新登录';
            }

            return response($res)->header('X-TOKEN', $jwt);
            echo json_encode($res);
        }
    }

    public function getUserInfo(Request $request)
    {
        // p($request->headers,1);
        $jwt = $request->header('x-token','');

        if (empty($jwt)) {
            $res['msg'] = 'You do not have permission to access.';
            echo json_encode($res);
            exit;
        }

        try {
            // JWT::$leeway = 60;
            $decoded = JWT::decode($jwt, self::KEY, ['HS256']);
            $arr = (array)$decoded;

            if ($arr['exp'] < time()) {
                $res['msg'] = '请重新登录';
            } else {
                $res['result'] = 'success';
                $res['info'] = $arr;
            }
        } catch (ExpiredException $e) {
            $res['msg'] = 'token已过期';
        } catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            // $res['msg'] = 'Token验证失败,请重新登录';
        }

        return response($res);
    }
}
