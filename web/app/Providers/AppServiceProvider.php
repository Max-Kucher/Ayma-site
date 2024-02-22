<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Response\ResponseStrategy;
use App\Contracts\Response\XmlResponseStrategy;
use App\Contracts\Response\JsonResponseStrategy;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ResponseStrategy::class, function ($app) {
            $request = $app->make(Request::class);

            if ($request->accepts('application/json')) {
                return new JsonResponseStrategy();
            }

            return new XmlResponseStrategy();
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
