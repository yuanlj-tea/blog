<?php


namespace App\Libs\BloomFilter;

use RedisPHP;

/**
 * 使用redis实现的布隆过滤器
 */
abstract class BloomFilterRedis
{
    /**
     * 需要使用一个方法来定义bucket的名字
     */
    protected $bucket;

    protected $hashFunction;

    public function __construct()
    {
        if (!$this->bucket || !$this->hashFunction) {
            throw new Exception("需要定义bucket和hashFunction", 1);
        }
        $this->hash = new BloomFilterHash;
        $this->redis = RedisPHP::connection();
    }

    /**
     * 添加到集合中
     */
    public function add($string)
    {
        $this->redis->multi();
        foreach ($this->hashFunction as $function) {
            $hash = $this->hash->$function($string);
            $this->redis->setbit($this->bucket, $hash, 1);
        }
        return $this->redis->exec();
    }

    /**
     * 查询是否存在, 存在的一定会存在, 不存在有一定几率会误判
     */
    public function exists($string)
    {
        $this->redis->multi();

        $len = strlen($string);
        foreach ($this->hashFunction as $function) {
            $hash = $this->hash->$function($string, $len);
            $this->redis->getbit($this->bucket, $hash);
        }
        $res = $this->redis->exec();
        foreach ($res as $bit) {
            if ($bit == 0) {
                return false;
            }
        }
        return true;
    }

}