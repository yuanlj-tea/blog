<?php


namespace App\Http\Model;

use Closure;
use Illuminate\Database\Eloquent\Model as BaseModel;
use RedisPHP;
use Log;
use Illuminate\Database\Eloquent\Collection;

class Model extends BaseModel
{
    const DEFAULT_EXPIRE_TIME = 604800; // 86400 * 7

    /**
     * Indicates if the IDs are auto-incrementing.
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var bool read from writable database [force]
     */
    protected $useWriteConnection = false;

    /**
     * Get the attributes that should be converted to dates.
     * @return array
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * 获取当前Unix时间戳
     * @return int
     */
    public function freshTimestamp()
    {
        return request_time();
    }

    /**
     * 避免转换Unix时间戳为时间字符串
     *
     * @param \DateTime|int $value
     * @return \DateTime|int
     */
    public function fromDateTime($value)
    {
        return is_numeric($value) ? $value : strtotime($value);
    }

    /**
     * @inheritdoc
     */
    public function newQuery()
    {
        $build = parent::newQuery();
        $this->useWriteConnection && $build->useWritePdo();

        return $build;
    }

    /**
     * @param string $key
     * @param Closure $fresh
     * @param int $expire
     * @param bool $isArray
     * @return mixed
     */
    protected static function hashCache($key, Closure $fresh = null, $expire = self::DEFAULT_EXPIRE_TIME, $isArray = false)
    {
        if ($isArray) {
            $ret = RedisPHP::get($key);
        } else {
            $ret = RedisPHP::hGetAll($key);
        }

        if ($ret) {
            if ($isArray) {
                $data = json_decode($ret, true);
                if (!is_null($data)) {
                    $reData = [];
                    foreach ($data as $item) {
                        $model = new static($item);
                        $model->exists = true;
                        $reData[] = $model;
                    }
                    $list = new Collection($reData);
                    return $list;
                } else {
                    //log error, then get data from db;
                    Log::error('RedisPHP data json_decode error, data: ', ['data' => $ret]);
                }
            } else {
                $model = new static($ret);
                $model->exists = true;
                return $model;
            }
        }

        if ($fresh && $ret = $fresh()) {

            if ($isArray) {
                RedisPHP::set($key, json_encode($ret->toArray()));
            } else {
                RedisPHP::hMSet($key, $ret->toArray());
            }

            RedisPHP::expire($key, $expire);
        }

        return $ret;
    }

    /**
     * @param string $key
     * @param Closure $fresh
     * @param int $expire
     * @return mixed
     */
    protected static function stringCache($key, Closure $fresh = null, $expire = self::DEFAULT_EXPIRE_TIME)
    {
        if ($ret = Redis::get($key)) {
            return $ret;
        }

        if ($fresh && $ret = $fresh()) {
            Redis::set($key, $ret, $expire);
        }

        return $ret;
    }

    /**
     * @param array $where
     * @return static|null
     */
    public static function getOne(array $where)
    {
        return static::where($where)->first();
    }

}