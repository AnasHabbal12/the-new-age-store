<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use App\Services\CurrencyConverter;
use Illuminate\Support\Facades\App;

class CurrencyConverterController extends Controller
{
    public function store (Request $request) {
        $request->validate([
            'currency_code' => 'required|string|size:3',
        ]);

        $currencyCode = $request->input('currency_code');

        $baseCurrencyCode = config('app.currency');

        $cashKey = 'currency_rate_' . $currencyCode;

        $rate = Cache::get($cashKey, 0);

        if(!$rate) {

            //dd(config('services.currency_converter.api_key'));
            //$converter = new CurrencyConverter(config('services.currency_converter.api_key')); old but new is from app service provider
            //$converter = App::make('curency.converter');  1
            //$converter = app()->make('curency.converter'); 2
            $converter = app('currency.converter'); //3
            $rate = $converter->convert($baseCurrencyCode, $currencyCode);


            Cache::put($cashKey, $rate, now()->addMinutes(60));
        }

        Session::put('currency_code', $currencyCode);

        //Session::put('currency_rate', $rate);
        return redirect()->back();
        //return redirect()
    }
}
