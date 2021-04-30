<?php

namespace RobertSeghedi\News;

use Illuminate\Support\ServiceProvider;

class NewsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('RobertSeghedi\News\Models\News');
        $this->app->make('RobertSeghedi\News\Models\Article');
        $this->app->make('RobertSeghedi\News\Models\Category');
        $this->app->make('RobertSeghedi\News\Models\Comment');
        $this->app->make('RobertSeghedi\News\Models\Like');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }
}
