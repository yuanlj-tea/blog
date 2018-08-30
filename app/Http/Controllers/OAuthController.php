<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Authorizer;
use AjaxResponse;

use App\Http\Requests;

class OAuthController extends Controller
{
    public function accessToken()
    {
        try {
            return AjaxResponse::success(Authorizer::issueAccessToken());
        } catch (Exception $e) {
            return AjaxResponse::fail($e->getMessage());
        }
    }

    public function newAuthorize(Request $request)
    {
        try {
            //登陆成功后
            if ($request->isMethod('get')) {
                //http://www.blog.com/oauth/authorize?client_id=demo&redirect_uri=http://www.blog.com/oauth/callback&response_type=code&state=6071
                $authParams = Authorizer::getAuthCodeRequestParams();
                $formParams = array_except($authParams, 'client');
                $formParams['client_id'] = $authParams['client']->getId();

                $return = [
                    'params' => $formParams,
                    'client' => $authParams['client'],
                ];
                return view('oauth.newAuthorize',['data' => json_encode($return)]);
                return AjaxResponse::success($return);
            } elseif ($request->isMethod('post')) {
                //获取OAuth 验证参数
                $params = Authorizer::getAuthCodeRequestParams();

                //判断登录
                $user = $request->input('user');
                $pwd = $request->input('pwd');

                $params['username'] = $user;

                if (empty($user) || empty($pwd)) {
                    return AjaxResponse::fail('缺少参数');
                }

                //验证密码
                if($user != 'root' || $pwd != '123456'){
                    return AjaxResponse::fail('密码错误');
                }

                //验证成功跳转到回调地址
                $redirectUri = Authorizer::issueAuthCode('user', $params['username'], $params);
                return AjaxResponse::success($redirectUri);

            } else {
                throw new Exception('非法请求');
            }
        } catch (Exception $e) {
            return AjaxResponse::fail($e->getMessage());
        }
    }

    public function userInfo()
    {
        try {
            $userName = Authorizer::getResourceOwnerId();
            echo $userName;die;

        } catch (Exception $e) {
            return AjaxResponse::fail($e->getMessage());
        }
    }

    public function callback(Request $request)
    {
        $code = $request->input('code','');
        if(empty($code)){
            return AjaxResponse::fail('缺少code参数');
        }

        //获取access_token
        $param = [];
        $param['grant_type'] = 'authorization_code';
        $param['client_id'] = 'demo';
        $param['client_secret'] = 'aikdhakshdajsdga';
        $param['redirect_uri'] = 'http://www.blog.com/oauth/callback';
        $param['code'] = $code;

        $q = http_build_query($param);
        $url = "http://www.blog.com/oauth/access_token?".$q;

        $res = oa_http_get($url);
        $res = json_decode($res,true);

        $access_token = '';
        if($res['code']){
            $access_token = $res['info']['access_token'];
        }else{
            return AjaxResponse::fail($res);
        }

        //获取用户信息
        $url = "http://www.blog.com/oauth/user_info?access_token=".$access_token;
        $res = oa_http_get($url);
        p($res,1);

    }
}
