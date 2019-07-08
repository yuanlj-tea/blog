<?php

namespace App\Console\Commands;

use App\Libs\Common;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Monolog\Logger;
use Monolog\Handler\StdoutHandler;

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
        // $logger = new Logger('my_logger');
        // $logger->pushHandler(new StdoutHandler());

        $config = \Kafka\ConsumerConfig::getInstance();
        $config->setMetadataRefreshIntervalMs(10000);
        $config->setMetadataBrokerList('127.0.0.1:9092');
        $config->setGroupId('test-1');
        $config->setBrokerVersion('0.10.0.0');
        $config->setTopics(array('test'));

        $consumer = new \Kafka\Consumer();
        // $consumer->setLogger($logger);
        $consumer->start(function($topic, $part, $message) {
            print_r($message);
        });

        // $this->comment(PHP_EOL.Inspiring::quote().PHP_EOL);
    }
}
