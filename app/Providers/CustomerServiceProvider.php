<?php

namespace App\Providers;

use App\Services\Transaction\TransactionService;
use Illuminate\Support\ServiceProvider;

class CustomerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $services = [
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
