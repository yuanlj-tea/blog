<?php
/**
 * SSO-SERVER:SSO服务中心
 * 用于登录验证，全局会话建立，access_token的颁发及验证，登录注销&注销时通知子系统注销局部会话
 */

namespace App\Http\Controllers\SSO;

use App\Libs\Common;
use App\Libs\CurlRequest;
use App\Libs\Response;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;
use RedisPHP;
use Firebase\JWT\ExpiredException;

class SsoServer extends Controller
{
    //jwt加密秘钥
    const KEY = '1gHuiop975cdashyex9Ud23ldsvm2Xq';

    //SSO-CLIENT 签名验证APP_ID
    const APP_ID = 'a7JbDTEWSw';

    //SSO-CLIENT 签名验证APP_KEY
    const APP_KEY = 's02x44obtm';

    //SSO-SERVER存储access_token与session_id对应关系的hash key
    private $hash_key = 'SSO_SERVER_TOKEN';

    //子系统退出登录接口URL
    private $subsysterm_logout_url = [
        'http://www.blog.com/sso/site_a/logout'
    ];


    /**
     * 登录
     * @param Request $request
     */
    public function login(Request $request)
    {
        $method = $request->method();
        if ($method == 'GET') {

            //如果sso中心已经登录，就跳转回单站点回调地址(带上access_token)
            if (isset($_SESSION['SSO_SERVER_IS_LOGIN']) && $_SESSION['SSO_SERVER_IS_LOGIN'] == 1) {

                //单站点回调地址
                $redirect_url = base64_decode($request->input('redirect_url', ''));
                if (empty($redirect_url)) {
                    return Response::fail('缺少回调地址');
                }

                //获取session_id对应access_token，跳转到回调地址
                $session_id = session_id();
                // $access_token = RedisPHP::hGet($this->hash_key, $session_id);
                $access_token = RedisPHP::command('hget', [$this->hash_key, $session_id]);

                if (!empty($access_token)) {
                    return redirect(sprintf("%s?access_token=%s", $redirect_url, $access_token));
                } else {
                    //todo 注销登录返回到登录页面 ?
                }
            }

            return view('sso.server.login');

        } elseif ($method == 'POST') {
            $user = xss_filter($request->input('user', ''));
            $pwd = xss_filter($request->input('pwd', ''));
            $redirect_url = base64_decode($request->input('redirect_url', ''));

            if ($user == 'demo' && $pwd == 'demo') {
                if (empty($redirect_url)) {
                    return Response::fail([], '缺少回调地址');
                }
                //设置session
                $_SESSION['SSO_SERVER_IS_LOGIN'] = 1;
                $session_id = session_id();

                //生成access_token
                $nowtime = time();
                $expLong = 24 * 60 * 60; //access_token过期时长，设为和session过期时长一样
                $token = [
                    'iss' => '', //签发者
                    'aud' => '', //jwt所面向的用户
                    'iat' => $nowtime, //签发时间
                    'nbf' => $nowtime + 0, //在什么时间之后该jwt才可用
                    'exp' => $nowtime + $expLong, //过期时间
                    'exp_long' => $expLong,
                    'data' => [
                        'username' => $user
                    ]
                ];
                setcookie(session_name(), session_id(), $token['exp'], '/');
                $access_token = JWT::encode($token, self::KEY);

                //保存access_token和session_id的对应关系
                // RedisPHP::hset($this->hash_key, $session_id, $access_token);
                RedisPHP::command('hset', [$this->hash_key, $session_id, $access_token]);

                // return redirect(sprintf("%s?access_token=%s", $redirect_url, $access_token));
                return Response::succ(['redirect_url' => sprintf("%s?access_token=%s", $redirect_url, $access_token)], '登录成功!');
            } else {
                return Response::fail([], '登录失败！用户名或密码错误！');
            }
        }
    }

    /**
     * 验证token
     * @param Request $request
     * @return false|\Illuminate\Http\JsonResponse|string
     */
    public function validateToken(Request $request)
    {
        $res['result'] = 'fail';
        $access_token = $request->input('access_token', '');

        if (empty($access_token)) {
            return Response::fail([], '缺少access_token');
        }

        try {
            $decoded = JWT::decode($access_token, self::KEY, ['HS256']);
            $arr = (array)$decoded;

            $res['result'] = 'success';
            $res['info'] = $arr;

            $res['exp_long'] = $arr['exp'];

        } catch (ExpiredException $e) {
            $res['msg'] = 'token已过期,请重新登录';
        } catch (\Exception $e) {
            // $res['msg'] = $e->getMessage();
            $res['msg'] = 'Token验证失败,请重新登录';
        }
        if ($res['result'] == 'fail') {
            return Response::fail($res, 'token验证成功');
        } else {
            return Response::succ($res);
        }

    }

    /**
     * SSO退出登录
     */
    public function logout(Request $request)
    {
        $access_token = $request->input('access_token', '');
        if (empty($access_token)) {
            return Response::fail('缺少access_token');
        }

        $hashVal = RedisPHP::hgetall($this->hash_key);
        if (!empty($hashVal)) {
            if (!empty($session_id = array_search($access_token, $hashVal))) {
                $sessionDriver = ini_get('session.save_handler');

                //清除SSO-SERVER全局会话&hash数据
                Common::clearSession($sessionDriver, $session_id);
                RedisPHP::hdel($this->hash_key, $session_id);

                //循环调用子系统注销接口，清除子系统局部会话session
                foreach ($this->subsysterm_logout_url as $v) {

                    $p = [];
                    $p['app_id'] = self::APP_ID;
                    $p['ts'] = time();
                    $p['access_token'] = $access_token;
                    $p['sign'] = generate_sign($p, self::APP_KEY);

                    $curl = CurlRequest::getInstance();
                    $res = $curl->post($v, $p);
                    \Log::info(json_encode($p));
                    \Log::info($res);
                }

                return Response::succ('退出登录成功');
            }
        } else {
            return Response::fail('sso server:hash数据为空');
        }
    }
}
