<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;

class TestJwt extends Controller
{
    public function index()
    {

        return view('home.test');
    }

    public function login()
    {

        define('KEY', '1gHuiop975cdashyex9Ud23ldsvm2Xq'); //密钥

        $res['result'] = 'failed';

        $action = isset($_GET['action']) ? $_GET['action'] : '';


        if ($action == 'login') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $username = htmlentities($_POST['user']);
                $password = htmlentities($_POST['pass']);

                if ($username == 'demo' && $password == 'demo') { //用户名和密码正确，则签发tokon
                    $nowtime = time();
                    $token = [
                        'iss' => 'http://www.helloweba.net', //签发者
                        'aud' => 'http://www.helloweba.net', //jwt所面向的用户
                        'iat' => $nowtime, //签发时间
                        'nbf' => $nowtime + 10, //在什么时间之后该jwt才可用
                        'exp' => $nowtime + 600, //过期时间-10min
                        'data' => [
                            'userid' => 1,
                            'username' => $username
                        ]
                    ];
                    $jwt = JWT::encode($token, KEY);
                    $res['result'] = 'success';
                    $res['jwt'] = $jwt;
                } else {
                    $res['msg'] = '用户名或密码错误!';
                }
            }
            echo json_encode($res);

        } else {
            $jwt = isset($_SERVER['HTTP_X_TOKEN']) ? $_SERVER['HTTP_X_TOKEN'] : '';
            if (empty($jwt)) {
                $res['msg'] = 'You do not have permission to access.';
                echo json_encode($res);
                exit;
            }

            try {
                JWT::$leeway = 60;
                $decoded = JWT::decode($jwt, KEY, ['HS256']);
                $arr = (array)$decoded;
                if ($arr['exp'] < time()) {
                    $res['msg'] = '请重新登录';
                } else {
                    $res['result'] = 'success';
                    $res['info'] = $arr;
                }
            } catch (Exception $e) {
                $res['msg'] = 'Token验证失败,请重新登录';
            }

            echo json_encode($res);
        }
    }
}
