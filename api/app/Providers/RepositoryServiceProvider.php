<?php

namespace App\Providers;


use App\Repositories\CarroRepository;
use App\Repositories\CarroRepositoryEloquent;
use App\Repositories\MarcaRepository;
use App\Repositories\MarcaRepositoryEloquent;
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
        $this->app->bind(CarroRepository::class, CarroRepositoryEloquent::class);
        $this->app->bind(MarcaRepository::class, MarcaRepositoryEloquent::class);
    }
}
