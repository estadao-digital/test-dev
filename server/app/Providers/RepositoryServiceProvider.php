<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
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
        $this->app->bind(\App\Repositories\CarRepository::class, \App\Repositories\CarRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\BrandRepository::class, \App\Repositories\BrandRepositoryEloquent::class);
        //:end-bindings:
    }
}
