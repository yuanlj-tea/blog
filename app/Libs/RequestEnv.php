<?php

namespace App\Libs;

class RequestEnv
{
    const TRACE_ID = 'trace-id';

    // 配置忽略检测 header 的路由
    const HEADER_CHECK_EXCLUDE = [
    ];

    /**
     * 调用信贷网关的 header
     * @var array
     */
    private static $commonEnv = [];

    /**
     * 客户端准入校验 & header 环境变量初始化
     */
    public static function checkClient(): void
    {
        // 追加请求流水号
        self::setTraceId();
    }


    /**
     * 设置通用环境变量
     * @param $key
     * @param $value
     */
    public static function setEnv($key, $value)
    {
        self::$commonEnv[self::convertKey($key)] = $value;
    }

    /**
     * 获取 环境变量
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public static function getEnv($key, $default = null): ?string
    {
        return self::$commonEnv[self::convertKey($key)] ?? $default;
    }

    /** 做下header 键的转换，以防上面常量的键定义成 _ 形式的命名
     * @param $key
     * @return mixed|string
     */
    private static function convertKey($key)
    {
        $key = str_replace('_', '-', $key);
        $key = strtolower($key);

        return $key;
    }

    /**
     * 设置请求序列号
     * @param bool $refresh 是否刷新trace-id,true:是
     */
    public static function setTraceId($traceId = '', $refresh = false): void
    {
        if (empty(self::getTraceId()) || $refresh) {
            // 请求头中是否有流水号
            [$m, $t] = explode(' ', microtime());
            $default = date('Ymdhis', $t) . floor($m * 10000) . mt_rand(100000, 999999);

            $traceId = is_cli() ? $default : (!empty($traceId) ? $traceId : $default);
            self::setEnv(self::TRACE_ID, $traceId);
        }
    }

    // 获取请求序列号
    public static function getTraceId(): string
    {
        return self::getEnv(self::TRACE_ID, '');
    }

    /**
     * 获取所有环境变量
     * @return array
     */
    public static function getCommonEnv(): array
    {
        return self::$commonEnv;
    }

    public static function clearCommonEnv()
    {
        self::$commonEnv = [];
    }
}