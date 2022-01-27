<?php

namespace App\Libs\Facade;

abstract class Facade
{
    private static $facadeInstance = [];

    private static $accessor = [];

    /**
     * 子类重写该方法用于传入子类构造函数的参数
     * @return array
     */
    protected static function initArgs()
    {
        return [];
    }

    /**
     * 获取真实的类
     * @return mixed
     */
    abstract public function getFacadeAccessor();

    public static function __callStatic($name, $arguments)
    {
        if (!isset(self::$facadeInstance[static::class])) {
            $instance = new static();
            $cl = $instance->getFacadeAccessor();

            self::$facadeInstance[static::class] = $cl;
        } else {
            $cl = self::$facadeInstance[static::class];
        }

        if (!isset(self::$accessor[$cl])) {
            self::$accessor[$cl] = new $cl(...static::initArgs());
        }
        return self::$accessor[$cl]->$name(...$arguments);
    }

    public function clear($class)
    {
        unset(self::$accessor[$class]);
    }
}