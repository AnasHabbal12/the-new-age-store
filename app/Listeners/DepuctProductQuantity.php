<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cart;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Events\OrderCreated;
use Throwable;

class DepuctProductQuantity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {

        $order = $event->order;
        //dd($order);
        try {
            foreach($order->products as $product) {
                $product->decrement('quantity', $product->order_item->quantity);
                // Product::where('id', $cart->product_id)
                // ->update([
                //     'quantity' => DB::raw('quantity - '. $item->quantity),
                // ]);
            }
        }
        catch(Throwable $e) {

        }
    }
}
