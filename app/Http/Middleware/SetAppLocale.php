<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetAppLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        ////////////////////////// languages
        //$locale = request('locale', Cookie::get('locale', config('app.locale'))); من الكوكي
        $locale = request()->route('locale');
        if (strlen($locale) > 2) {
            $locale = Crypt::decrypt($locale);
        }
        App::setLocale($locale);
        //Cookie::queue('locale', $locale, 60);
        /////////////////////////

        // اعطاء قيمة البراميتر بالرابط
        URL::defaults([
            'locale' => $locale
        ]);
        // لحتى ما ياخد السلاغ او البراميتر التاني بدال براميتر اللغة
        Route::current()->forgetParameter('locale');

        return $next($request);
    }
}
