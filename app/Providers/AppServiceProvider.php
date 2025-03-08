<?php

namespace App\Providers;

use App\Models\ApiKeyCounter;
use App\Services\DeepSeekService;
use Database\Factories\ApiKeyCounterFactory;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


        Model::unguard();
    }
}
