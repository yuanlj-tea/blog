<?php

namespace App\Libs;

use Illuminate\Http\Request;
use Elasticsearch\ClientBuilder;
use AjaxResponse;
use App\Http\Controllers\Controller;

class Es extends Controller
{
    /**
     * 获取es客户端
     * @return \Elasticsearch\Client
     */
    public static function getClient()
    {
        $hosts = [
            [
                'host' => env('ES_HOST', '192.168.79.206'),
                'port' => env('ES_PORT', '9200'),
            ]
        ];

        return ClientBuilder::create()
            ->setHosts($hosts)
            ->build();
    }

    /**
     * 创建索引
     */
    public static function createIndex()
    {
        $client = self::getClient();
        $params = [
            'index' => 'my_index',
            'body' => [
                'settings' => [
                    'number_of_shards' => 3,
                    'number_of_replicas' => 2
                ],
                'mappings' => [
                    'my_type' => [
                        '_source' => [
                            'enabled' => true
                        ],
                        'properties' => [
                            'first_name' => [
                                'type' => 'keyword',
                                'analyzer' => 'standard'
                            ],
                            'age' => [
                                'type' => 'integer'
                            ]
                        ]
                    ]
                ]
            ]
        ];


        // Create the index with mappings and settings now
        $response = $client->indices()->create($params);
    }

    /**
     * 删除索引
     */
    public static function delIndex($index_name)
    {
        $client = self::getClient();

        $params = ['index' => $index_name];
        $response = $client->indices()->delete($params);
    }

    /**
     * 添加document
     */
    public static function addDoc($index, $type, $id, $data)
    {
        $params = [
            'index' => $index,
            'type' => $type,
            'id' => $id,
            'body' => $data,
        ];
        self::getClient()->index($params);
    }

    /**
     * 删除document
     * @param $index
     * @param $type
     * @param $id
     */
    public static function delDoc($index, $type, $id)
    {
        $params = [
            'index' => $index,
            'type' => $type,
            'id' => $id
        ];
        self::getClient()->delete($params);
    }

    /**
     * 搜索文章
     * @param $param
     * @param $page
     * @param $perPage
     * @return array
     */
    public static function searchArticle($param, $page, $perPage)
    {
        $page = ($page - 1) < 0 ? 0 : $page - 1;

        $params = [
            'index' => env('ES_INDEX'),
            'type' => env('ES_TYPE'),
            //'preference' => Session::getId(),
            'search_type' => 'dfs_query_then_fetch',
            "from" => $page * $perPage,
            "size" => $perPage,
            "body" => $param
        ];

        try {
            $response = self::getClient()->search($params);

            $res['total'] = 0;
            $res['per_page'] = 0;
            $res['current_page'] = 0;
            $res['last_page'] = 0;
            $res['data'] = [];

            if (isset($response['hits']['total']) && $response['hits']['total'] > 0) {
                $res['total'] = $response['hits']['total'];
                $res['per_page'] = intval($perPage);
                $res['current_page'] = intval($page + 1);
                $res['last_page'] = ceil(intval($res['total']) / $res['per_page']);

                foreach ($response['hits']['hits'] as $value) {

                    //高亮返回数据处理
                    if (isset($value['highlight'])) {

                        foreach ($value['highlight'] as $kk => $vv) {

                            if (empty($kk)) {
                                continue;
                            }

                            $value['_source'][$kk] = $vv[0];

                        }
                    }



                    $res['data'][] = $value['_source'];
                }
            }

            return ['code' => 1, 'msg' => $res];

        } catch (\Exception $e) {
            return ['code' => 0, 'msg' => sprintf("FILE:%s,LINE%s,MSG:%s", $e->getFile(), $e->getLine(), $e->getMessage())];
        }
    }
}
