<?php

namespace App\Providers;

use App\Services\Customer\CustomerService;
use App\Services\Customer\ICustomerService;
use App\Services\Product\IProductService;
use App\Services\Product\ProductService;
use App\Services\Transaction\ITransactionService;
use App\Services\Transaction\TransactionService;
use Illuminate\Support\ServiceProvider;

class CustomServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $services = [
            ICustomerService::class => CustomerService::class,
            IProductService::class => ProductService::class,
            ITransactionService::class => TransactionService::class,
        ];

        foreach ($services as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
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
