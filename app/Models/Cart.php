<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use App\Observers\CartObserver;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\User;


class Cart extends Model
{
    use HasFactory, HasUuids;

    public $icrementing = false;

    protected $fillable = [
        'cookie_id', 'user_id', 'product_id', 'quantity', 'options', 
    ];

    public static function booted(){
        static::observe(CartObserver::class);
        static::addGlobalScope('cookie_id', function(Builder $builder) {
            $builder->where('cookie_id', '=', Cart::getCookieId());
        });
        // static::creating(function(Cart $cart) {
        //     $cart->id = Str::uuid();
        // });
    }

    public function user() {
        return $this->belongsTo(User::class)->withDefault(
            ['name' => 'Anonymous', ]
        );
    }

    public function product() {
        return $this->belongsTo(product::class);
    }

    public static function getCookieId() {
        $cookie_id = Cookie::get('cart_id');
        if(!$cookie_id) {
            $cookie_id = Str::uuid();
            Cookie::queue('cart_id', $cookie_id, 30*24*60);
        }
        return $cookie_id;
    }
}
