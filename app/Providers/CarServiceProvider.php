<?php

namespace App\Providers;

use App\Model\Car;
use App\Repositories\CarRepository;
use App\Services\CarService;
use Illuminate\Support\ServiceProvider;

class CarServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CarService::class, function ($app){
            return new CarService(new CarRepository(new Car()));
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
