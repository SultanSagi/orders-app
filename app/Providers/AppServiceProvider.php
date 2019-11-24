<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\User;
use App\Product;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['orders.index', 'orders._form'], function($view) {
            $view->with('users', User::pluck('name', 'id'));
            $view->with('products', Product::pluck('name', 'id'));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
