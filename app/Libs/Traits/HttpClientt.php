<?php

namespace App\Libs\Traits;

use GuzzleHttp\Promise\Utils;
use Log;
use GuzzleHttp\Client;
use App\Libs\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

trait HttpClientt
{
    private $baseOptions = [
        'base_uri' => '',
        'timeout' => 5.0,
        // 'proxy' => 'http://127.0.0.1:8888',
    ];

    /**
     * return base guzzle options
     * @return array
     */
    protected function getBaseOptions(): array
    {
        $options = method_exists($this, 'getBaseOptions') ? $this->getBaseOptions() : $this->baseOptions;

        return $options;
    }

    /**
     * return http client
     * @param array $options
     * @return Client
     */
    protected function getHttpClient(array $options)
    {
        return new Client($options);
    }

    /**
     * convert response contents to json
     * @param ResponseInterface $response
     * @return mixed|string
     */
    protected function unwrapResponse(ResponseInterface $response)
    {
        $contentType = $response->getHeaderLine('Content-Type');
        $contents = $response->getBody()->getContents();

        if (stripos($contentType, 'json') !== false || stripos($contentType, 'javascript')) {
            return json_decode($contents, true);
        } elseif (stripos($contentType, 'xml') !== false) {
            return json_decode(json_encode(simplexml_load_string($contents)), true);
        } elseif (is_json_str($contents)) {
            return json_decode($contents, true);
        }

        return $contents;
    }

    /**
     * make http request
     * @param $method
     * @param $endpoint
     * @param array $options
     * @param array $additionalOptions
     * @return mixed|string
     */
    protected function request($method, $endpoint, $options = [], $additionalOptions = [])
    {
        $call = strstr($endpoint, '?', true) ?: $endpoint;
        try {
            $ret = $this->unwrapResponse($this->getHttpClient($this->getBaseOptions())->{$method}($endpoint, $options));

            $resLog = isset($additionalOptions['ignoreResponse']) ? 'success' : $ret;

            Log::info('web_client', [
                'request' => [
                    'url' => $endpoint,
                    'data' => $options,
                    'call' => $call,
                ],
                'response' => $resLog,
            ]);

            return $ret;
        } catch (\Throwable $t) {
            Log::info('web_client_error', [
                'request' => [
                    'url' => $endpoint,
                    'data' => $options,
                    'call' => $call,
                ],
                'response' => [
                    'file' => $t->getFile(),
                    'line' => $t->getLine(),
                    'msg' => $t->getMessage(),
                    'trace' => $t->getTraceAsString(),
                ],
            ]);

            throw new RequestException($t->getMessage());
        }
    }

    /**
     * make get request
     * @param $endpoint
     * @param array $query
     * @param array $headers
     * @return mixed|string
     */
    protected function get($endpoint, $query = [], $headers = [])
    {
        return $this->request('get', $endpoint, [
            'headers' => $headers,
            'query' => $query,
        ]);
    }

    /**
     * make post request
     * content-type:application/x-www-form-urlencoded
     * https://guzzle-cn.readthedocs.io/zh_CN/latest/quickstart.html#post
     * @param $endpoint
     * @param array $params
     * @param array $headers
     * @return mixed|string
     */
    protected function post($endpoint, $params = [], $headers = [])
    {
        return $this->request('post', $endpoint, [
            'headers' => $headers,
            'form_params' => $params,
        ]);
    }

    /**
     * make post request
     * content-type:multipart/form-data
     * https://guzzle-cn.readthedocs.io/zh_CN/latest/quickstart.html#id11
     * @param $endpoint
     * @param $params
     * @param array $headers
     * @return mixed|string
     */
    protected function postFormData($endpoint, $params, $headers = [])
    {
        return $this->request('post', $endpoint, [
            'headers' => $headers,
            'multipart' => $params,
        ]);
    }

    /**
     * 上传文件
     * @param $endpoint
     * @param $params
     * @param array $headers
     * @return mixed|string
     */
    protected function postFile($endpoint, $params, $headers = [])
    {
        $data = $this->createMultipart($params);
        foreach ($_FILES as $name => $FILE) {
            $data[] = [
                'name' => $name,
                'filename' => $FILE['name'],
                'contents' => fopen($FILE['tmp_name'], 'r'),
            ];
        }

        return $this->request('post', $endpoint, [
            'headers' => $headers,
            'multipart' => $data,
        ]);
    }

    /**
     * @param array $params
     * @param string $prefix
     * @return array
     */
    protected function createMultipart(array $params, $prefix = '')
    {
        $return = [];
        foreach ($params as $name => $value) {
            $item = [
                'name' => empty($prefix) ? $name : "{$prefix}[{$name}]",
            ];
            switch (true) {
                case (is_object($value) && $value instanceof \CURLFile):
                    $item['contents'] = fopen($value->getFilename(), 'r');
                    $item['filename'] = $value->getPostFilename();
                    $item['headers'] = [
                        'content-type' => $value->getMimeType(),
                    ];
                    break;
                case (is_string($value) && is_file($value)):
                    $item['contents'] = fopen($value, 'r');
                    break;
                case (is_array($value)):
                    $return = array_merge($return, $this->createMultipart($value, $item['name']));
                    continue 2;
                default:
                    $item['contents'] = $value;

            }
            $return[] = $item;
        }

        return $return;
    }

    /**
     * 发送json请求
     * content-type:application/json
     * @param $endpoint
     * @param array $params
     * @param array $headers
     * @return mixed|string
     */
    protected function postJson($endpoint, $params = [], $headers = [])
    {
        return $this->request('post', $endpoint, [
            'headers' => $headers,
            'json' => $params,
        ]);
    }

    /**
     * 发送一个数据流的请求
     * https://guzzle-cn.readthedocs.io/zh_CN/latest/quickstart.html#id9
     * @param $endpoint
     * @param array $params
     * @param array $headers
     * @return mixed|string
     */
    protected function postBody($endpoint, $params = [], $headers = [])
    {
        return $this->request('post', $endpoint, [
            'headers' => $headers,
            'body' => $params,
        ]);
    }

    /**
     * 并发发送post json请求
     * @param array $request
     * @return array
     */
    protected function concurrentPostJson($request = [])
    {
        $client = $this->getHttpClient($this->getBaseOptions());
        $promises = [];

        try {
            foreach ($request as $k => $v) {
                $promises[$k] = $client->postAsync($v['url'], [
                    'headers' => $v['headers'] ?? [],
                    'json' => $v['body'] ?? [],
                ]);
            }
            $results = Utils::unwrap($promises);

            $res = [];
            foreach ($results as $rk => $rv) {
                $res[$rk] = $this->unwrapResponse($rv);
            }

            Log::info('web_client', [
                'request' => $request,
                'response' => $res,
            ]);

            return $res;
        } catch (\Throwable $t) {
            Log::info('web_client_error', [
                'request' => $request,
                'response' => [
                    'file' => $t->getFile(),
                    'line' => $t->getLine(),
                    'msg' => $t->getMessage(),
                    'trace' => $t->getTraceAsString(),
                ],
            ]);

            throw new RequestException($t->getMessage());
        }
    }
}