<?php

namespace App\Providers;

use App\Model\Brand;
use App\Repositories\BrandRepository;
use App\Services\BrandService;
use Illuminate\Support\ServiceProvider;

class BrandServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BrandService::class, function ($app){
            return new BrandService(new BrandRepository(new Brand()));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
