<?php

namespace App\Providers;

use App\Http\Repository\User\UserRepository;
use App\Http\Repository\User\UserRepositoryImpl;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepository::class, UserRepositoryImpl::class);
//        $this->app->bind('path.public', function() {
//            return realpath(base_path().'/../public_html');
//        });
        //TODO ********************** IMPORTANT !

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
