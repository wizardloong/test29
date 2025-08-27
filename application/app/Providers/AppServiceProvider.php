<?php

namespace App\Providers;

use App\Repositories\CarRepository;
use App\Repositories\Eloquent\EloquentUserRepository;
use App\Repositories\EloquentCarRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(CarRepository::class, EloquentCarRepository::class);
        
        $this->app->bind(
            \App\UseCases\User\CreateUser\CreateUser::class,
            function ($app) {
                return new \App\UseCases\User\CreateUser\CreateUser(
                    $app->make(UserRepository::class)
                );
            }
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
