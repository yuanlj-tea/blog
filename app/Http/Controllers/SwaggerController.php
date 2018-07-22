<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SwaggerController extends Controller
{
    /**
     * 返回JSON格式的Swagger定义
     *
     * 这里需要一个主`Swagger`定义：
     * @SWG\Swagger(
     *   @SWG\Info(
     *     title="我的`Swagger`API文档",
     *     version="1.0.0"
     *   )
     * )
     */
    public function getJson()
    {
        // 你可以将API的`Swagger Annotation`写在实现API的代码旁，从而方便维护，
        // `swagger-php`会扫描你定义的目录，自动合并所有定义。这里我们直接用`Controller/`
        // 文件夹。
        $swagger = \Swagger\scan(app_path('Http/Controllers/'));

        return response()->json($swagger, 200);
    }

    /**
     * 假设是项目中的一个API
     *
     * @SWG\Get(path="/swagger/my-data",
     *   tags={"project"},
     *   summary="拿一些神秘的数据",
     *   description="请求该接口需要先登录。",
     *   operationId="getMyData",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="reason",
     *     type="string",
     *     description="拿数据的理由",
     *     required=true,
     *   ),
     *   @SWG\Response(response="default", description="操作成功")
     * )
     */
    public function getMyData(Request $request)
    {
        $reason = $request->input('reason', '');

        return json_encode(['reason' => $reason]);
    }

    /**
     * 假设是项目中的一个API
     *
     * @SWG\Get(path="/swagger/getMyData1",
     *   tags={"project1"},
     *   summary="拿一些神秘的数据",
     *   description="请求该接口需要先登录。",
     *   operationId="getMyData",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="reason",
     *     type="string",
     *     description="拿数据的理由",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="formData",
     *     name="reason1",
     *     type="string",
     *     description="拿数据的理由",
     *     required=false,
     *   ),
     *   @SWG\Response(response="default", description="操作成功")
     *
     * )
     */
    public function getMyData1()
    {
        $swagger = \Swagger\scan(app_path('Http/Controllers/'));

        return response()->json($swagger, 200);
    }
}
