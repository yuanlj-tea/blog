<?php

namespace App\Services\Common;

class AjaxResponse
{

    /**
     * 错误码
     */
    private $arrMsg = [
        "login_validation_fail" => "登录验证失败!",
    ];

    public function getMsg($code)
    {
        return isset($this->arrMsg[$code]) ? $this->arrMsg[$code] : "未知错误(" . $code . ")";
    }

    /**
     * 输出json数据
     * @param  int $intCode 输出码
     * @param  any $anyInfo 输出内容
     * @param  bool $hasResponse 是否response
     * @param  string $jsonpCallback jsonp回调函数
     * @return void or array
     */

    protected function echoAjaxJson($intCode = 0, $anyInfo = null, $hasResponse = true, $jsonpCallback = "")
    {
        $out = [
            'code' => $intCode,
            'info' => $anyInfo
        ];
        if (!empty($jsonpCallback)) {
            return $jsonpCallback . "(" . json_encode($out) . ")";
        }
        if ($hasResponse) {
            return response()->json($out);
        }
        return json_encode($out);
    }

    /**
     * 成功时输出
     * @param  $anyInfo      输出内容描述
     * @param  $hasResponse  是否response
     * @param  string $jsonpCallback jsonp回调函数
     */
    public function success($anyInfo, $hasResponse = true, $jsonpCallback = "")
    {

        return $this->echoAjaxJson(1, $anyInfo, $hasResponse, $jsonpCallback);

    }

    /**
     * 失败时输出
     * @param  $anyInfo 输出内容描述
     * @param  $hasResponse  是否response
     * @param  $errCode      错误码，不能等于1
     * @param  string $jsonpCallback jsonp回调函数
     */
    public function fail($anyInfo, $hasResponse = true, $jsonpCallback = "", $errCode = 0)
    {
        if ($errCode == 1) {
            throw new \Exception('错误码已占用');
        }
        return $this->echoAjaxJson($errCode, $anyInfo, $hasResponse, $jsonpCallback);
    }

    //登录验证失败
    public function loginValidationFail()
    {
        return $this->echoAjaxJson(0, $this->arrMsg['login_validation_fail'], true, "");
    }


}