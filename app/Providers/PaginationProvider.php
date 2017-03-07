<?php

namespace App\Providers;

use App\MyPaginationPresenter;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\ServiceProvider;

class PaginationProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::presenter(function (AbstractPaginator $paginator) {
            return new MyPaginationPresenter($paginator);
        });
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