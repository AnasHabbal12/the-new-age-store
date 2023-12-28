<?php

namespace App\Helper;

use NumberFormatter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

class Currency {

    public function __invoke(...$params) {
        return static::format(...$params);
    }

    public static function format($amount, $currency = null) {

        $baseCurrecy = config('app.currency', 'USD');

        $formatter = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);

        if($currency === null ) {

            $currency = Session::get('currency_code', $baseCurrecy);

        }

        if ($currency != $baseCurrecy) {
            $rate = Cache::get('currency_rate_' . $currency, 1);
            $amount = $amount * $rate;
        }

        //dd(Cache::get('currency_rate_' . $currency, 1));
        //dd( $currency);
        return $formatter->formatCurrency($amount, $currency);

    }

}
