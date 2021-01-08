<?php

namespace App\Console\Commands;

use App\Libs\Es;
use Illuminate\Console\Command;

class SearchEs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:es';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $host = 'http://es-tst1.shihuo.io';
        $port = '80';

        $param['index'] = 'shihuo_supplier_list_latest';
        $param['type'] = 'list_sku';
        $param['body']['query']['bool']['must_not'] = [
            "terms" => [
                "supplierTag" => [1001, 1002, 1003, 1004]
            ]
        ];

        $res = Es::getClient($host, $port)->search($param);
        pd($param, $res);
    }
}
