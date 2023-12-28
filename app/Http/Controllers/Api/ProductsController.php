<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Product;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProductResource;

class ProductsController extends Controller
{

    public function __construct() {
        $this->middleware('auth:sanctum')->except('index', 'show');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // return Product::filter($request->query())->with('category:id,name', 'store:id,name', 'tags:id,name')->paginate(); الكوليكشن كامل بدون تعديل مع العلاقات 
        $product = Product::filter($request->query())->with('category:id,name', 'store:id,name', 'tags:id,name')->paginate();
        return ProductResource::collection($product); //  الكوليكشن كامل مع تعديل مع العلاقات 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'in:active,inactive', 
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|gt:price',
            // السلاغ من بوتيد
        ]);

        $user = $request->user(); // للصلاحيات
        if (!$user->tokenCan('product.create')) {
            return ['message' => 'you dont have priviliage'];
        }

        $product = Product::create($request->all());

        return Response::json($product, 201 // header, ['xxx' => 'xxx']
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //return Product::findOrFail($id); محتويات الموديل العادية
        //return $product->load('category:id,name', 'store:id,name', 'tags:id,name'); محتويات الموديل مع العلاقات
        return new ProductResource($product); //مع تعديلات
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category_id' => 'sometimes|required|exists:categories,id',
            'status' => 'in:active,inactive', 
            'price' => 'sometimes|required|numeric|min:0',
            'compare_price' => 'nullable|numeric|gt:price',
            // السلاغ من بوتيد
        ]);

        $user = $request->user(); // للصلاحيات
        if (!$user->tokenCan('product.update')) {
            return ['message' => 'you dont have priviliage'];
        }

        $product->update($request->all());

        return Response::json($product, 201 // header, ['xxx' => 'xxx']
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Auth::guard('sanctum')->user(); // للصلاحيات
        if (!$user->tokenCan('product.delete')) {
            return ['message' => 'you dont have priviliage'];
        }

        Product::destroy($id);
        return [
            'message' => 'product deleted successfully'
        ];
    }
}
