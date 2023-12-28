<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;
use App\Events\OrderCreated;

class CheckoutController extends Controller
{
    public function create(CartRepository $cart) {

        if ($cart->get()->count() == 0) {
            return redirect()->route('home');
        }
        return view('front.checkout', [
            'cart' => $cart,
            'countries' => Countries::getNames(),
        ]);
    }

    public function store(Request $request, CartRepository $cart) {
        //dd($request);
        $request->validate([
            'address.billing.first_name' => ['required', 'string', 'max:255'],
            'address.billing.last_name' => ['required', 'string', 'max:255'],
            'address.billing.email' => ['required', 'string', 'max:255'],
            'address.billing.phone_number' => ['required', 'string', 'max:255'],
            'address.billing.city' => ['required', 'string', 'max:255'],
        ]);

        $items = $cart->get()->groupBy('product.store_id')->all();


        DB::beginTransaction();

        try {
            foreach($items as $store_id => $cart_items) {

                $order = Order::create([
                'store_id' => $store_id, 
                'user_id' => Auth::id(),
                'payment_method' => 'cod', 
                'discount' => 0,
                ]);

                foreach($cart_items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,
                    ]);
                }

                foreach($request->post('address') as $type => $address) {
                    //dd($type);
                    $address['type'] = $type;
                    $order->adresses()->create($address);
                }
            }

            //$cart->empty();

            DB::commit();

            //event('order.created', $order);
            event(new OrderCreated ($order));
        }
        catch (Trowable $e) {
            DB::rollback();
            throw $e;
    }

    return redirect()->route('home');
}
}