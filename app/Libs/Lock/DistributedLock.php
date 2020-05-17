<?php


namespace App\Libs\Lock;

use App\Libs\Traits\Sinleton;
use RedisPHP;

class DistributedLock
{
    use Sinleton;

    private $default_ttl = 60;

    public function lock($key, $randomValue, $ttl)
    {
        $script = <<<EOT
    local key   = KEYS[1]
    local value = KEYS[2]
    local ttl   = KEYS[3]

    local ok = redis.call('setnx', key, value)

    if ok == 1 then
    redis.call('expire', key, ttl)
    end
    return ok
EOT;

        $redis = RedisPHP::connection();
        $getLock = $redis->eval($script, 3, $key, $randomValue, $ttl);
        return $getLock;
    }

    public function getLock($key, $randomValue, $ttl)
    {
        $redis = RedisPHP::connection();
        $getLock = $redis->set($key, $randomValue, 'NX', 'EX', $ttl);
        return $getLock;
    }

    /**
     * 释放锁
     * @param $key
     * @param $randomValue
     */
    public function release($key, $randomValue)
    {
        $redis = RedisPHP::connection();
        $redisValue = $redis->get($key);
        if ($redisValue == $randomValue) {
            $redis->del($key);
        }
    }

    public function getLockCallBack($key, $callback, $callbackParam = [])
    {
        $randomValue = gen_uid();
        if ($this->getLock($key, $randomValue, $this->default_ttl)) {
            call_user_func_array($callback, $callbackParam);
            $this->release($key, $randomValue);
        }
    }

    public function block($key, $randomValue, $ttl, $blockTTL)
    {
        $getLock = false;
        for ($i = 0; $i < $blockTTL * 2; $i++) {
            if ($this->getLock($key, $randomValue, $ttl)) {
                $getLock = true;
                break;
            } else {
                usleep(500000);
            }
        }

        if (!$getLock) {
            throw new LockTimeoutException();
        }
    }
}