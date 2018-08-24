<?php

namespace App\Libs;

use Illuminate\Http\Request;
use Elasticsearch\ClientBuilder;
use AjaxResponse;
use App\Http\Controllers\Controller;

class Es extends Controller
{
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
     * 添加索引
     */
    public static function addIndex($index,$type,$id,$data)
    {
        $params = [
            'index' => $index,
            'type' => $type,
            'id' => $id,
            'body' => $data,
        ];
        self::getClient()->index($params);
    }
}
