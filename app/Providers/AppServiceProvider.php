<?php

namespace App\Providers;

use App\Services\CurrencyConverter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('currency.converter', function () {
            return new CurrencyConverter(config('services.currency_converter.api_key'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        JsonResource::withoutWrapping(); // لالغاء كبمة داتا من استجابة الااي بي اي



        Validator::extend('filter', function($attribute, $value) {
            if($value == 'laravel')
                return false;
            return true;
            }, 'this name is frorbidden!');
            Paginator::useBootstrapFour();
    }
}
