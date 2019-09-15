<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Common\Common;

class CommonProvider extends ServiceProvider
{
    /**
    * 服务提供者加是否延迟加载.
    *
    * @var bool
    */
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
        $this->app->singleton('Common', function () {
            return new Common();
        });
    }
    
     /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['Common'];
    }
}
