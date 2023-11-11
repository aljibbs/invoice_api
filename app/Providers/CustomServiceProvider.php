<?php

namespace App\Providers;

use App\Services\Customer\CustomerService;
use App\Services\Product\ProductService;
use App\Services\Transaction\TransactionService;
use App\Services\TransactionItem\TransactionItemService;
use Illuminate\Support\ServiceProvider;

class CustomServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $services = [
            CustomerService::class,
            ProductService::class,
            TransactionService::class,
        ];

        foreach ($services as $svc) {
            $this->app->bind($svc, function () use ($svc) {
                return new $svc();
            });
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
