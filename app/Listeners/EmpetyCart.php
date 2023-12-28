<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
//use App\Repositories\Cart\CartModelRepository;
use App\Facades\Cart;

class EmpetyCart
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle($event): void
    {
        //$event->order->empty();
        // $cart = new CartModelRepository();
        // $cart->empty();
        Cart::empty();

    }
}
