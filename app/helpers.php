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
        // curl_setopt($ch, CURLOPT_PROXY, '192.168.79.251:8888');
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

if(!function_exists('is_cli')){
    /*
    判断当前的运行环境是否是cli模式
    */
    function is_cli()
    {
        return preg_match("/cli/i", php_sapi_name()) ? true : false;
    }
}

/**
 * 变量友好化打印输出
 * @param variable  $param  可变参数
 * @example dump($a,$b,$c,$e,[.1]) 支持多变量，使用英文逗号符号分隔，默认方式 print_r，查看数据类型传入 .1
 * @version php>=5.6
 * @return void
 */
function pd(...$param){

    $tag = is_cli() ? "\n" : "<pre>";
    echo $tag;
    if(end($param) === .1){
        array_splice($param, -1, 1);

        foreach($param as $k => $v){
            echo $k>0 ? $tag : '';

            ob_start();
            var_dump($v);

            echo preg_replace('/]=>\s+/', '] => <label>', ob_get_clean());
        }
    }else{
        foreach($param as $k => $v){
            echo $k>0 ? $tag : '', print_r($v, true); // echo 逗号速度快 https://segmentfault.com/a/1190000004679782
        }
    }
    echo is_cli() ? "\n" : '</pre>';
    die;
}

/**
 * 变量友好化打印输出
 * @param variable  $param  可变参数
 * @example dump($a,$b,$c,$e,[.1]) 支持多变量，使用英文逗号符号分隔，默认方式 print_r，查看数据类型传入 .1
 * @version php>=5.6
 * @return void
 */
function pp(...$param){

    $tag = is_cli() ? "\n" : "<pre>";
    echo $tag;
    if(end($param) === .1){
        array_splice($param, -1, 1);

        foreach($param as $k => $v){
            echo $k>0 ? $tag : '';

            ob_start();
            var_dump($v);

            echo preg_replace('/]=>\s+/', '] => <label>', ob_get_clean());
        }
    }else{
        foreach($param as $k => $v){
            echo $k>0 ? $tag : '', print_r($v, true); // echo 逗号速度快 https://segmentfault.com/a/1190000004679782
        }
    }
    echo is_cli() ? "\n" : '</pre>';
}

/**
 * @return int
 */
function request_time()
{
    return $_SERVER['REQUEST_TIME'] ?? $_SERVER['REQUEST_TIME'] = time();
}

if(!function_exists('gen_uid')){
    function gen_uid(){
        do {
            $uid = str_replace('.', '0', uniqid(rand(0, 999999999), true));
        } while (strlen($uid) != 32);
        return $uid;
    }
}

if (!function_exists('is_json_str')) {
    function is_json_str($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}