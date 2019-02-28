<?php

namespace App\Console\Commands;

use App\Libs\Common;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

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
        $session_id = '6l70rtmchd7kr3nk4euv8u4140';
        $sessionDriver = ini_get('session.save_handler');
        Common::clearSession($sessionDriver, $session_id);

        dd($_SESSION);
        // $this->comment(PHP_EOL.Inspiring::quote().PHP_EOL);
    }
}
