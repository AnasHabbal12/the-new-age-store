<?php 

namespace App\facades;

use App\Repositories\Cart\CartRepository;
use Illuminate\Support\Facades\Facade;

class Cart extends Facade {
    public static function getFacadeAccessor() {
        return CartRepository::class;
    } 
}