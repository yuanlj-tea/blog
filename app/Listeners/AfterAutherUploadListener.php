<?php

namespace App\Listeners;

use App\Events\AfterAutherUploadEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AfterAutherUploadListener
{
    protected $receiver;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  AfterAutherUploadEvent  $event
     * @return void
     */
    public function handle(AfterAutherUploadEvent $event)
    {
        $receiver = $event->receiver;
        file_put_contents('/tmp/auther_upload.log',print_r($receiver,true),FILE_APPEND);
    }
}
