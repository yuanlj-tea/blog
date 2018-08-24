<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Libs\Es;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use AjaxResponse;

class EsController extends Controller
{
    //es客户端
    public $esClient;

    public function __construct()
    {
        $this->esClient = Es::getClient();
    }

    /**
     * 添加索引
     */
    public function addIndex($index,$type,$id,$data)
    {
        $params = [
            'index' => $index,
            'type' => $type,
            'id' => $id,
            'body' => $data,
        ];
        return $this->esClient->index($params);
    }

    public function initIndex()
    {
        $data = Article::select('*')->get()->toArray();

        $es_index = env('ES_INDEX');
        $es_type = 'article';

        foreach ($data as $k=>$v){

            $this->addIndex($es_index,$es_type,$v['art_id'],$v);
            echo $v['art_id'] . '----' . $v['art_title'] . "<br>";
        }

    }



}
