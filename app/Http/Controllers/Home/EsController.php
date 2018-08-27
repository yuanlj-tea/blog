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

    public $es_index;

    public $es_type;


    public function __construct()
    {
        $this->esClient = Es::getClient();
        $this->es_index = env('ES_INDEX', 'blog');
        $this->es_type = env('ES_TYPE', 'article');
    }

    /**
     * 添加索引
     */
    public function addIndex($index, $type, $id, $data)
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

        foreach ($data as $k => $v) {

            $this->addIndex($es_index, $es_type, $v['art_id'], $v);
            echo $v['art_id'] . '----' . $v['art_title'] . "<br>";
        }

    }

    public function search()
    {
        $param['index'] = $this->es_index;
        $param['type'] = $this->es_type;

        //select * from blog_article where art_tag like "%苹果%";
        //$param['body']['query']['match']['art_tag'] = '苹果';

        //select * from blog_article where art_title like '%总局%' and art_id = 5;
        //$param['body']['query']['bool']['must'] = [
        //    ['match' => ['art_title'=>'总局']],
        //    ['match' => ['art_id'=>5]]
        //];

        //select * from blog_article where art_title like '%总局%' or art_id = 14;
        //$param['body']['query']['bool']['should'] = [
        //    ['match' => ['art_title'=>'总局']],
        //    ['match' => ['art_id'=>14]]
        //];

        //select * from blog_article where art_id >1 and art_id < 6;
        $param['body']['query']['range'] = [
            'art_id' => ['gt' => 1, 'lt' => 6]
        ];


        //p($param,1);
        $res = Es::getClient()->search($param);
        return AjaxResponse::success($res);
    }

    public function searchArticle(Request $request)
    {
        $art_id = $request->input('art_id', 0);
        $art_title = $request->input('art_title', '');
        $cate_id = $request->input('cate_id', 0);
        $key = $request->input('key', '');
        $perPage = $request->input('perPage', 20);
        $page = $request->input('page', 1);

        $filter = [];

        //select * blog_article where art_id in (?,?,?);
        if (!empty($art_id)) {
            $filter[]['terms']['art_id'] = explode(',', $art_id);
        }

        //select * from blog_article where cate_id = ?;
        if(!empty($cate_id)){
            $filter[]['term']['cate_id'] = $cate_id;
        }

        //范围cate_id>=6 && cate_id <=11
//        $filter[]['range']['cate_id'] = [
//            'gte' => 6,
//            'lte' => 11,
//        ];

//        $filter[]['range']['base.art_id'] = ['gt' => 1];


        //关键词搜索
        if (!empty($key)) {

            $searchFields = [
                'art_title^2',
            ];

            $param['query']['bool']['must']['query_string'] = [
                'query' => $key,
                //'fields' => $searchFields,
                //'analyzer' => "ik_max_word",
                //'analyzer' => "whitespace",
                //'split_on_whitespace' => true,
                //'default_operator' => 'AND',
                'analyze_wildcard' => true,
                'all_fields' => true,
                'split_on_whitespace' => true,
                'auto_generate_phrase_queries' => true,
                'use_dis_max' => false
            ];
            $param['sort'] = ["art_id" => ["order" => "desc"]];

        } else {
            $param['sort'] = ["art_id" => ["order" => "desc"]];
        }

        if (sizeof($filter)) {
            $param['query']['bool']['filter'] = $filter;
        }

        //select * from blog_article where art_tag like "%苹果%";
        //$param['query']['match']['art_tag'] = '苹果';

        //select * from blog_article where art_title like '%总局%' or art_id = 14;
        //$param['query']['bool']['should'] = [
        //    ['match' => ['art_title'=>'总局',]],
        //    ['match' => ['art_id'=>'14',]],
        //];

        //select * from blog_article where art_title like '%总局%' and art_id = 5;
        //$param['query']['bool']['must'] = [
        //    ['match' => ['art_title'=>'总局',]],
        //    ['match' => ['art_id'=>'5',]],
        //];

        //select * from blog_article where art_id >1 and art_id < 6;
        //$param['query']['range'] = [
        //    'art_id' => ['gt' => 1, 'lt' => 6]
        //];

        //高亮返回查询结果
        $param['highlight']['number_of_fragments'] = 0;
        $param['highlight']['fragment_size'] = 2147483647;
        $param['highlight']['pre_tags'] = '<em class="KY-key-light">';
        $param['highlight']['post_tags'] = '</em>';
        $param['highlight']['fields'] = ['*' => new \stdClass()];

        //p($param,1);
        $res = Es::searchArticle($param, $page, $perPage);
        if ($res['code'] == 1) {
            return AjaxResponse::success($res['msg']);
        } else {
            return AjaxResponse::fail($res['msg']);
        }
    }

}
