<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\PaginationService;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CategoryService::class, function () {
            return new CategoryService();
        });
        
        $this->app->singleton(ProductService::class, function () {
            return new ProductService();
        });
        
        $this->app->singleton(PaginationService::class, function () {
            return new PaginationService();
        });
    }

    public function boot()
    {
        //
    }
}