<?php

namespace App\Http\Middleware;

use App\Libs\Traits\Ratelimit;
use Closure;
use RedisPHP;
use AjaxResponse;

/**
 * 令牌桶算法实现限流
 * Class TokenBucketRatelimit
 * @package App\Http\Middleware
 */
class TokenBucketRatelimit
{
    use Ratelimit;

    //每分钟可以访问的次数
    private $limitNum = 5;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $rateLimitKey = $this->getLimitKey($request);
        $limit = $this->checkLimit($rateLimitKey, $this->limitNum, 60);

        if (!$limit['status']) {
            return AjaxResponse::fail($limit['msg']);
        }

        return $next($request);
    }

    protected function checkLimit($key, $initNum, $expire)
    {
        $nowtime = time();
        $res = ['status' => true, 'msg' => ''];

        $redis = RedisPHP::connection();
        $redis->watch($key);

        $limitVal = $redis->get($key);
        if ($limitVal) {
            $limitVal = json_decode($limitVal, true);
            $newNum = min($initNum, ($limitVal['num'] - 1) + (($initNum / $expire) * ($nowtime - $limitVal['time'])));
            if ($newNum > 0) {
                $redisVal = json_encode(['num' => $newNum, 'time' => time()]);
            } else {
                $res['status'] = false;
                $res['msg'] = '当前时刻令牌消耗完';
                return $res;
            }

        } else {
            $redisVal = json_encode(['num' => $initNum, 'time' => time()]);
        }
        $redis->multi();
        $redis->set($key, $redisVal);

        $result = $redis->exec();
        if (!$result) {
            $res['status'] = false;
            $res['msg'] = '访问频次过多！';
        }
        return $res;
    }
}
