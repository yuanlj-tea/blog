<?php

namespace App\Http\Middleware;

use App\Http\Model\AuthClients;
use Closure;
use AjaxResponse;

class ValidateSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $clientSign = $encryptionType = "";
        $a = $request->all();
        if (isset($a['sign'])) {
            $clientSign = $a['sign'];
            unset($a['sign']);
        }

        if (isset($a['encryptionType'])) {
            $encryptionType = $a['encryptionType'];
            unset($a['encryptionType']);
        }

        ksort($a);
        $srvData = http_build_query($a, '', '&', PHP_QUERY_RFC3986);
        if (empty($clientSign)) {
            return AjaxResponse::fail("签名参数不能为空!");
        }

        $appID = $request->input('app_id');
        if (empty($appID)) {
            return AjaxResponse::fail("参数错误!");
        }
        $ts = $request->input('ts', '');
        if (!empty($ts)) {
            $sub = time() - intval($ts);
            if ($sub > 180 || $sub < -180) {
                return AjaxResponse::fail("请求过期!");
            }
        }

        $objAuth = AuthClients::where('APP_ID', $appID)->first(['APP_KEY', 'ALLOW_IP', 'ALLOW_ROUTE']);

        if (!isset($objAuth->APP_KEY)) {
            return AjaxResponse::fail("app_id失效");
        }
        if (!empty($objAuth->ALLOW_IP)) {
            $ip = isset($_SERVER['HTTP_X_REAL_IP']) ? $_SERVER['HTTP_X_REAL_IP'] : $request->ip();
            if (!in_array($ip, explode(",", $objAuth->ALLOW_IP))) {
                return AjaxResponse::fail("ip限制!" . $ip);
            }
        }

        if (empty($objAuth->APP_KEY)) {
            return AjaxResponse::fail("app_key失效");
        }

        $res = $encryptionType == 'md5' ? verify_signature_by_md5($clientSign, $srvData, $objAuth->APP_KEY) : verify_signature($clientSign, $srvData, $objAuth->APP_KEY);
        if (!$res) {
            return AjaxResponse::fail("签名错误!");
        }

        $path = $request->path();
        if (!empty($objAuth->ALLOW_ROUTE)) {
            if (!in_array($path, explode(",", $objAuth->ALLOW_ROUTE))) {
                return AjaxResponse::fail("接口权限限制!" . $path);
            }
        }
        return $next($request);
    }
}
