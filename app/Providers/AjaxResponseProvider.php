<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Common\AjaxResponse;


class AjaxResponseProvider extends ServiceProvider
{

    //延迟加载
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('AjaxResponse', function () {
            return new AjaxResponse();
        });

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['AjaxResponse'];
    }

}
