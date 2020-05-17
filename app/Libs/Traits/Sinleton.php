<?php


namespace App\Libs\Traits;


trait Sinleton
{
    private static $_instance;

    public static function getInstance(...$args)
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new static(...$args);
        }

        return self::$_instance;
    }
}