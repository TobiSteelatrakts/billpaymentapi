<?php

namespace App\Providers;

use App\Exceptions\Handler;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {

     
    }


    public function boot(): void{

        $this->app->bind(
            ExceptionHandler::class,
            Handler::class
        );   

        Passport::personalAccessTokensExpireIn(Carbon::now()->endOfDay());
    }
}
