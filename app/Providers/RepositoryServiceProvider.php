<?php

namespace App\Providers;

use App\Repository\ClientRepositoryInterface;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\BaseRepositoryInterface;
use App\Repository\Eloquent\InvoiceRepository;
use App\Repository\InvoiceRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);
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
