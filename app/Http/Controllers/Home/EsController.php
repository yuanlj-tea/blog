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
     * 创建索引
     * @return false|\Illuminate\Http\JsonResponse|string|void
     */
    public function createIndex()
    {
        $params = [
            'index' => $this->es_index,
            /*'body' => [
                'settings' => [
                    'number_of_shards' => 5,
                    'number_of_replicas' => 10
                ]
            ]*/
        ];

        try{
            $this->esClient->indices()->create($params);
            return AjaxResponse::success('生成索引:'.$this->es_index.',成功');
        }catch(\Exception $e){
            return AjaxResponse::fail($e->getMessage());
        }
    }

    /**
     * 删除索引
     */
    public function delIndex()
    {
        $params = ['index'=>$this->es_index];
        $res = $this->esClient->indices()->delete($params);
        return AjaxResponse::success('删除索引成功');
    }

    /**
     * 创建mapping
     */
    public function createMapping()
    {
        $params = [
            'index' => $this->es_index,
            'type' => $this->es_type,
            'body' => [
                $this->es_type => [
                    '_source' => [
                        'enabled' => true
                    ],
                    '_all' => [
                        'analyzer' => 'ik_max_word',
                        'search_analyzer' => 'ik_max_word',
                        'term_vector' => 'no',
                        'store' => false
                    ],
                    'properties' => [
                        'art_content' => [
                            'type' => 'text',
                            //'analyzer' => 'ik_max_word',
                            'fields' => [
                                'keyword' => [
                                    'type' => 'keyword',
                                    'ignore_above' => 256
                                ]
                            ]
                        ],
                        'art_description' => [
                            'type' => 'text',
                            //'analyzer' => 'ik_max_word',
                            'fields' => [
                                'keyword' => [
                                    'type' => 'keyword',
                                    'ignore_above' => 256
                                ]
                            ]
                        ],
                        'art_editor' => [
                            'type' => 'text',
                            //'analyzer' => 'ik_max_word',
                            'fields' => [
                                'keyword' => [
                                    'type' => 'keyword',
                                    'ignore_above' => 256
                                ]
                            ]
                        ],
                        'art_id' => [
                            'type' => 'long'
                        ],
                        'art_tag' => [
                            'type' => 'text',
                            //'analyzer' => 'ik_max_word',
                            'fields' => [
                                'keyword' => [
                                    'type' => 'keyword',
                                    'ignore_above' => 256
                                ]
                            ]
                        ],
                        'art_thumb' => [
                            'type' => 'text',
                            //'analyzer' => 'ik_max_word',
                            'fields' => [
                                'keyword' => [
                                    'type' => 'keyword',
                                    'ignore_above' => 256
                                ]
                            ]
                        ],
                        'art_title' => [
                            'type' => 'text',
                            'analyzer' => 'ik_max_word',
                            'fields' => [
                                'keyword' => [
                                    'type' => 'keyword',
                                    'ignore_above' => 256
                                ]
                            ]
                        ],
                        'atr_time' => [
                            'type' => 'long',
                        ],
                        'art_view' => [
                            'type' => 'long'
                        ],
                        'cate_id' => [
                            'type' => 'long'
                        ]
                    ]
                ]
            ]
        ];
        $res = $this->esClient->indices()->putMapping($params);
        return AjaxResponse::success('生成mapping成功');
    }

    /**
     * 查看mapping
     * @return false|\Illuminate\Http\JsonResponse|string|void
     */
    public function getMapping()
    {
        $mapping = $this->esClient->indices()->getMapping();
        return AjaxResponse::success($mapping);
    }

    /**
     * 添加文档
     */
    public function addDoc($index, $type, $id, $data)
    {
        $params = [
            'index' => $index,
            'type' => $type,
            'id' => $id,
            'body' => $data,
        ];
        return $this->esClient->index($params);
    }

    /**
     * 初始化文档
     */
    public function initIndex()
    {
        $data = Article::select('*')->get()->toArray();

        $es_index = env('ES_INDEX');
        $es_type = 'article';

        foreach ($data as $k => $v) {

            $this->addDoc($es_index, $es_type, $v['art_id'], $v);
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
        // $param['body']['query']['range'] = [
        //     'art_id' => ['gt' => 1, 'lt' => 6]
        // ];

        // $param['body']['query']['match']['art_title']['query']='苹';
        // $param['body']['query']['term']['art_tag']='最强大脑,围棋';
        $param['body']['query']['match']['art_title']='果';

        //p($param,1);
        $res = Es::getClient()->search($param);
        return AjaxResponse::success($res);
    }

    public function searchArticle(Request $request)
    {
        $art_id = $request->input('art_id', 0);
        $art_title = $request->input('art_title', '');
        $art_tag = $request->input('art_tag','');
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

        if(!empty($art_tag)){
            //select * from blog_article where art_tag = $art_tag; (中文精确值搜索,字段后要加.keyword)
            $filter[]['term']['art_tag.keyword'] = $art_tag;
            // $param['query']['match']['art_tag'] = $art_tag;
            // $param['query']['constant_score']['filter']['term']['art_tag'] = $art_tag;
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

        if(!empty($art_title)){
            $param['query']['bool']['must'] = [
                [
                    'match' => [
                        'art_title' => $art_title
                    ]
                ]
            ];
        }


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

    /**
     * 更新远程词库
     * @param $dic
     */
    public function updateRemoteDic(Request $request)
    {
        $dic = $request->input('dic','');

        if(!empty($dic)){
            file_put_contents('/mnt/hgfs/test/Allen.txt',$dic.PHP_EOL,FILE_APPEND);
        }else{
            return AjaxResponse::fail('请传递要更新的词库数据');
        }
        return AjaxResponse::success('更新词库成功');

    }

}
