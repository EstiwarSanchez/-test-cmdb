<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Services\AlephApiServiceInterface;
use App\Services\AlephApiService;

class AlephApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AlephApiServiceInterface::class, function ($app) {
            return new AlephApiService(
                config('services.aleph.base_url'),
                config('services.aleph.api_key')
            );
        });
    }
}
