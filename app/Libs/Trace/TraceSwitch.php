<?php

namespace App\Libs\Trace;

class TraceSwitch
{
    private static $switch = true;

    public static function setSwitch(bool $bool)
    {
        self::$switch = $bool;
    }

    public static function getSwitch()
    {
        return self::$switch;
    }
}