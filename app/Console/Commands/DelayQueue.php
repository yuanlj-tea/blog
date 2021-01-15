<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use RedisPHP;

class DelayQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delay:queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '用redis有序集合实现延迟队列';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        RedisPHP::pipeline(function ($pipe) {
            for ($i = 0; $i < 10; $i++) {
                sleep(1);
                $pipe->setex("key:$i", 60, $i);
            }
        });
        die;

        $script = <<<LUA
    local delayQueue   = KEYS[1]
    local min          = KEYS[2]
    local max          = KEYS[3]

    local ok = redis.call('ZRANGEBYSCORE', delayQueue, min, max, 'limit', min, max)
    
    -- lua table的key是从1开始的
    if (ok[1]) then
        redis.call('ZREM', delayQueue, ok[1])
    end
    
    return ok
LUA;

        $redis = RedisPHP::connection();
        $delayQueue = 'test_delay_queue';
        $min = 0;

        while (true) {
            try {
                $max = time();
                $data = $redis->eval($script, 3, $delayQueue, $min, $max);
                if (!empty($data)) {
                    pp(sprintf("[%s] %s", date('Y-m-d H:i:s'), print_r($data, true)));
                }
            } catch (\Exception $e) {
                $errMsg = sprintf("[time] %s [file] %s [line] %s [msg] %s", date('Y-m-d H:i:s'), $e->getFile(), $e->getLine(), $e->getMessage());
                $this->error($errMsg);
            }
        }


    }
}
