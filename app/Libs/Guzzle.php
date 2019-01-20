<?php
/**
 * Created by PhpStorm.
 * User: yuanlj
 * Date: 2019/1/18
 * Time: 10:11
 */

namespace App\Libs;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise;

class Guzzle
{
    private static $guzzle = [];

    /**
     * 实例化guzzle
     * @param $base_uri
     * @return bool
     */
    private static function init($base_uri)
    {
        if (empty($base_uri)) {
            return false;
        }
        if (!isset(self::$guzzle[$base_uri])) {
            self::$guzzle[$base_uri] = new Client([
                // Base URI is used with relative requests
                'base_uri' => $base_uri,
                // You can set any number of default request options.
                'timeout' => 10.0,
                // https请求
                'verify' => true
            ]);
        }
        return true;
    }

    /**
     * 获取guzzle实例
     * @param $base_uri
     * @return bool|mixed
     */
    public static function getGuzzle($base_uri)
    {
        $res = self::init($base_uri);
        if ($res === false) {
            return false;
        }
        return self::$guzzle[$base_uri];
    }

    /**
     * 发送get请求
     * @param $base_uri 请求的url
     * @param $api 请求的接口
     * @param $query 请求数据 eg:['foo' => 'bar']
     * @param array $headers 请求头 eg:['Accept-Encoding' => 'gzip']
     * @param array $proxy 设置代理 eg:设置代理：http://127.0.0.1:8888,charles可以抓到请求包
     * @param array $cookies 请求cookie eg:['PHPSESSID' => 'web2~ri5m4tjbi6gk6eeu72ghg27l61']
     * @param string $domain 请求cookie的域名
     * @return mixed
     * @throws \Exception
     */
    public static function get($base_uri, $api, $query = [], $headers = [], $proxy = '', $cookies = [], $domain = '')
    {
        try {
            $instance = self::getGuzzle($base_uri);

            if (!empty($query)) {
                $data['query'] = $query;
            }
            if (!empty($headers)) {
                $data['headers'] = $headers;
            }
            if (!empty($proxy)) {
                $data['proxy'] = $proxy;
            }
            if(!empty($cookies)){
                $jar = new \GuzzleHttp\Cookie\CookieJar();
                $cookieJar = $jar->fromArray($cookies, $domain);
                $data['cookies'] = $cookieJar;
            }

            $response = $instance->get($api, $data);
            $resCode = $response->getStatusCode();

            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }
}