<?php

namespace App\Console\Commands;

use App\Http\Model\Article;
use App\Libs\BloomFilter\FilteRepeatedComments;
use App\Libs\Common;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Monolog\Logger;
use Monolog\Handler\StdoutHandler;
use App\Libs\Guzzle;
use RedisPHP;
use DB;

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
        $data = [];
        $j = 0;
        for($i = 0;$i<100000;$i++){
            $j++;
            $data[$i]['num'] = $i;
            if($j == 5000){
                $this->info('插入'.$j*5000);
                DB::table('test')->insert($data);
                $j = 0;
                $data = [];
            }
        }
        DB::table('test')->insert($data);
        $this->info('插入'.count($data));
        die;

        /*$this->info('begin');
        $s = microtime(true);
        $this->info($s);

        $redis = RedisPHP::connection();
        $range = range(1, 10000000);
        foreach ($range as $v) {
            $redis->setbit('test',$v , 1);
        }
        $e = microtime(true);
        $this->info(sprintf("%.2f", ($e - $s)));
        pd('end');*/


        ini_set('memory_limit', '4096M');
        $sm = memory_get_usage();

        $range = range(1, 10000000);

        $em = memory_get_usage();
        pd(($em-$sm) / 1024 / 1024);






        // DB::connection()->disableQueryLog();
        ini_set('memory_limit', '4096M');
        $s = microtime(true);

        //time:7.64s;memory:1240.304688 mb
        // $data = DB::table('test')->get();

        // time:254.72s;memory:18.000000 mb
        // DB::table('test')->chunk(5000,function($list){
        //
        // });

        // time:69.83s;memory:36.000000 mb
        // DB::table('test')->chunk(20000,function($list){
        //
        // });

        // time:32.93s;memory:70.007812 mb
        // DB::table('test')->chunk(50000,function($list){
        //
        // });

        //time:0.77s;memory:22.000000 mb
        // DB::table('test')->where('id','<=',100000)->chunk(10000,function($list){
        //
        // });

        // time:1.12s;memory:18.000000 mb
        // DB::table('test')->where('id','<=',100000)->chunk(5000,function($list){
        //
        // });

        //time:8.22s;memory:362.300781 mb
        // foreach(DB::table('test')->cursor() as $v){
        //     pp($v->num);
        // }

        //time:0.41s;memory:29.054688 mb
        foreach (DB::table('test')->where('id', '<=', 100000)->cursor() as $v) {
            // pp($v->num);
        }

        $e = microtime(true);
        $time = sprintf("%.2f", ($e - $s));
        $memory = memory_get_peak_usage(true) / 1024 / 1024;

        $this->info(sprintf("time:%ss;memory:%f mb", $time, $memory));
        // Article::get();
        // foreach(Article::cursor() as $v){
        //     pp($v->art_title);
        // }
        //
        // Article::chunk(2,function($list){
        //
        // });


        // $redis = RedisPHP::connection('foo');
        // RedisPHP::subscribe(['__keyevent@0__:expired'],function($message)use($redis){
        //     pp($message);
        //     pp($redis->get($message));
        // });

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
