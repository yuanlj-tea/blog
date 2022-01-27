<?php

namespace App\Libs\Trace;

class Resp
{
    private static $rawRespData = null;

    /**
     * @param $rawRespData
     */
    public static function setRawRespData($rawRespData)
    {
        self::$rawRespData = $rawRespData;
    }

    /**
     * @return false|string
     */
    public static function getRawRespData()
    {
        $ret = is_array(self::$rawRespData) ? json_encode(self::$rawRespData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : self::$rawRespData;
        self::clear();

        return $ret;
    }

    public static function clear()
    {
        self::$rawRespData = null;
    }
}