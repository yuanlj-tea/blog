<?php

namespace App\Listeners;

use App\Events\BeforeAutherUploadEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BeforeAutherUploadListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BeforeAutherUploadEvent  $event
     * @return void
     */
    public function handle(BeforeAutherUploadEvent $event)
    {
        //
    }
}
