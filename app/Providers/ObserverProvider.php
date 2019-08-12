<?php

namespace App\Providers;

use App\Http\Model\Article;
use App\Observers\ArticleObserve;
use Illuminate\Support\ServiceProvider;

class ObserverProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        file_put_contents('/tmp/test.log','222'.PHP_EOL,FILE_APPEND);
        Article::observe(ArticleObserve::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
