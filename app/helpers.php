<?php
if (!function_exists('p')) {
    function p($arr, $code = 0)
    {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
        if ($code == 1) {
            die;
        }
    }
}

if(!function_exists('oa_http_get')) {
    /**
     * http get 请求
     * @param  string
     */
    function oa_http_get($url){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Connection: close"));
        //curl_setopt($ch, CURLOPT_USERAGENT, "(kingnet oa web server)");
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $res=curl_exec($ch);
        if(curl_errno($ch) || empty($res))
        {
            $str = date('Y-m-d H:i:s').':'.
                $url.'--'.
                curl_errno($ch).'--'.
                json_encode($res).'--get--'.
                curl_error($ch).'--'.
                json_encode(curl_getinfo($ch));
            file_put_contents('/tmp/curl_error.log',  $str. PHP_EOL, FILE_APPEND);
        }
        curl_close($ch);

        return $res;
    }
}

/**
 * xss过滤
 * @param  array $input 需要过滤的数组
 * @return array
 */
function xss_filter($input)
{
    if (is_array($input)) {
        if (sizeof($input)) {
            foreach ($input as $key => $value) {
                if (is_array($value) && sizeof($value)) {
                    $input[$key] = xss_filter($value);
                } else {
                    if (!empty($value)) {
                        $input[$key] = htmlentities($value, ENT_QUOTES, 'UTF-8');
                    }
                }
            }
        }
        return $input;
    }
    return htmlentities($input, ENT_QUOTES, 'UTF-8');
}

if (!function_exists('xss_decode')) {
    /**
     * xss反转义
     * @param  array $input 需要反转义的数组
     * @return array
     */
    function xss_decode($input)
    {
        if (is_array($input)) {
            if (sizeof($input)) {
                foreach ($input as $key => $value) {
                    if (is_array($value) && sizeof($value)) {
                        $input[$key] = xss_decode($value);
                    } else {
                        if (!empty($value)) {
                            if(is_string($value)){
                                $input[$key] = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
                            }else{
                                $input[$key] = $value;
                            }
                        }
                    }
                }
            }
            return $input;
        }
        if(is_string($input)){
            return html_entity_decode($input,ENT_QUOTES,'UTF-8');
        }else{
            return $input;
        }
    }
}

if (!function_exists('generate_sign')) {
    function generate_sign($data, $appkey)
    {
        ksort($data);
        $param = http_build_query($data, '', '&', PHP_QUERY_RFC3986);
        $sign = hash_hmac('sha256', $param, $appkey);
        return $sign;
    }
}

if (!function_exists('verify_signature')) {
    /**
     * 验证签名
     * @param  string
     */
    function verify_signature($clientSign, $serverData, $key)
    {
        $srvSign = hash_hmac('sha256', $serverData, $key);
        if ($srvSign === $clientSign) {
            return true;
        }
        return false;
    }
}

if (!function_exists('verify_signature_by_md5')) {
    /**
     * 验证签名md5法
     * @param  string
     */
    function verify_signature_by_md5($clientSign, $serverData, $key)
    {
        $srvSign = md5($serverData . $key);
        if ($srvSign === $clientSign) {
            return true;
        }
        return false;
    }
}