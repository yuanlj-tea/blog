<?php

namespace Trace;

class ReqCtx
{
    protected static $context = [];

    /**
     * @param string $id
     * @param $value
     * @return mixed
     */
    public static function set(string $id, $value)
    {
        static::$context[$id] = $value;

        return $value;
    }

    /**
     * @param string $id
     * @param null $default
     * @return mixed|null
     */
    public static function get(string $id, $default = null)
    {
        return static::$context[$id] ?? $default;
    }

    /**
     * @param string $id
     * @return bool
     */
    public static function has(string $id)
    {
        return isset(static::$context[$id]);
    }

    /**
     * @param string $id
     * @param $value
     * @param null $default
     * @return mixed|null
     */
    public static function getOrSet(string $id, $value, $default = null)
    {
        if (!self::has($id)) {
            return self::set($id, $value);
        }
        return self::get($id);
    }

    /**
     * @param string $id
     */
    public static function destory(string $id)
    {
        if (self::has($id)) {
            unset(static::$context[$id]);
        }
    }
}