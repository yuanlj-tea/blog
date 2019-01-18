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