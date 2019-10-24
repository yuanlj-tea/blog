<?php

namespace App\Console\Commands;

use App\Libs\Common;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Monolog\Logger;
use Monolog\Handler\StdoutHandler;
use App\Libs\Guzzle;
use RedisPHP;

class Inspire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inspire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $redis = RedisPHP::connection('foo');
        RedisPHP::subscribe(['__keyevent@0__:expired'],function($message)use($redis){
            pp($message);
            pp($redis->get($message));
        });

        /*$s = microtime(true);
        for($i=0;$i<30;$i++){
            $base_uri = 'http://192.168.90.206:8001';
            $api = '/t2.php';

            $res = Guzzle::get($base_uri, $api, ['c' => 'd', 'a' => 'b']);
        }
        $e = microtime(true);
        pd(round($e - $s, 2));*/


        /*$config = \Kafka\ConsumerConfig::getInstance();
        $config->setMetadataRefreshIntervalMs(10000);
        $config->setMetadataBrokerList('127.0.0.1:9092');
        $config->setGroupId('test-1');
        $config->setBrokerVersion('0.10.0.0');
        $config->setTopics(array('test'));

        $consumer = new \Kafka\Consumer();
        $consumer->start(function ($topic, $part, $message) {
            print_r($message);
        });*/

        // $this->comment(PHP_EOL.Inspiring::quote().PHP_EOL);
    }
}
