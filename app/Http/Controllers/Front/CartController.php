<?php

namespace App\Http\Controllers\Front;

//use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use Illuminate\Support\Facaedes\App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    protected $cart;

    public function __construct(CartRepository $cart) {
        $this->cart = $cart;
    }
    
    public function index()
    {
        $car2 = Cart::select('id')->where('id')->get();
        return view('front.cart', [
            'cart' => $this->cart,
            'car2' => $car2,
        ]);
    }
    public function show(){

    }

    public function store(Request $request, CartRepository $cart)
    {
        $request->validate([
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['nullable', 'int', 'min:1']
        ]);
        $product = Product::findOrFail($request->post('product_id'));
        //dd($request->post('quantity'));
        $cart->add($product, $request->post('quantity'));

        return redirect()->route('cart.index')->with(
            'success', 'Product has been added to cart!!');
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            //'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['required', 'int', 'min:1']
        ]);
        //$product = Product::findOrFail($request->post('product_id'));
        //dd($id);
        $this->cart->update($id, $request->post('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //dd(id);
        //Cart::where('id', $id)->delete();
        $this->cart->delete($id);
        return [
            'message' => 'Item Deleted !',
        ];
    }
}
