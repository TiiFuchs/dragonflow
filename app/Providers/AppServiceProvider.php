<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use OpenAI\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Client::class, function () {
            $apiKey = config('services.openai.api_key');
            return \OpenAI::client($apiKey);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
