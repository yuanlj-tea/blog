<?php

namespace App\Http\Controllers\SSO;

use App\Libs\CurlRequest;
use App\Libs\Response;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use RedisPHP;

class SiteA extends Controller
{
    //SSO服务端URL
    private $SSO_URL = 'http://192.168.79.206:8002';

    private $site_domain = 'http://www.blog.com';

    //SSO-CLIENT存储access_token与session_id对应关系的hash key
    private $hash_key = 'SITE_A_HASH_KEY';

    //SSO服务端的APP_ID
    const APP_ID = 's02x44obtm';
    //SSO服务端的APP_KEY
    const APP_KEY = 'a7JbDTEWSw';

    /**
     * 检测是否登录
     */
    public function checkIsLogin()
    {
        if(isset($_SESSION['SITE_A_IS_LOGIN']) && $_SESSION['SITE_A_IS_LOGIN'] == 1){

            $userName = isset($_SESSION['LOGIN_IN_USER_NAME']) ? $_SESSION['LOGIN_IN_USER_NAME'] : '';
            echo "站点A已经登录，当前登录用户：".$userName;
        }else{
            return redirect(sprintf("%s?redirect_url=%s",$this->SSO_URL.'/sso/server/login',base64_encode($this->site_domain.'/sso/site_a/redirectUrl')));
        }
    }

    /**
     * 回调地址
     */
    public function redirectUrl(Request $request)
    {
        $access_token = $request->input('access_token','');
        if(empty($access_token)){
            return Response::fail([],'缺少access_token');
        }

        $p['app_id'] = self::APP_ID;
        $p['ts'] = time();
        $p['access_token'] = $access_token;
        $p['sign'] = generate_sign($p,self::APP_KEY);

        for($i=0;$i<3;$i++){
            $curl = CurlRequest::getInstance();
            $res = $curl->post($this->SSO_URL.'/sso/server/validateToken',$p);

            $user = '';
            if(!empty($res) && !empty($arr = json_decode($res,1))){
                if($arr['code'] == 0){
                    break;
                }
                $user = isset($arr['data']['info']['data']['username']) ? $arr['data']['info']['data']['username'] : '';
                $exp_long = isset($arr['data']['exp_long']) ? $arr['data']['exp_long'] : 0;
                break;
            }
        }
        if(!empty($user)){
            //设置session
            $_SESSION['SITE_A_IS_LOGIN'] = 1;
            $_SESSION['LOGIN_IN_USER_NAME'] = $user;
            setcookie(session_name(),session_id(),$exp_long,'/');

            //redis里存access_token和session_id对应关系
            RedisPHP::hset($this->hash_key,$access_token,session_id());

            // $userName = isset($_SESSION['LOGIN_IN_USER_NAME']) ? $_SESSION['LOGIN_IN_USER_NAME'] : '';
            // echo "站点A已经登录，当前登录用户：".$userName;
            return redirect($this->site_domain.'/sso/site_a/checkIsLogin');
        }else{
            return Response::fail('验证token错误');
        }
    }

    /**
     * 单点退出登录
     */
    public function logout(Request $request)
    {

    }
}
