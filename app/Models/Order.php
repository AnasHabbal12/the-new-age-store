<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderAdress;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
class Order extends Model
{
    use HasFactory;

    protected $fillable = ['store_id', 'user_id', 'payment_method', 'status', 'discount', 'total', 'tax', 'shipping'];

    public function products() {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id', 'id', 'id')
        ->using(OrderItem::class)
        ->as('order_item')
        ->withPivot(['product_name', 'price', 'quantity', 'options']);
    }

    public function store() {
        return $this->belongsTo(Store::class);
    }

    public function user() {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest Custommer'
        ]);
    }

    public function adresses() {
        return $this->hasMany(OrderAdress::class);
    }

    public function billingAdress() {
        return $this->hasOne(OrderAdress::class, 'order_id', 'id')->where('type', '=', 'billing');
    }

    public function shippingAdress() {
        return $this->hasOne(OrderAdress::class, 'order_id', 'id')->where('type', '=', 'shipping');
    }

    public static function booted() {
        static::creating(function(Order $order) {
            $order->number = Order::getNextOrderNumber();
        });
    }

    public static function getNextOrderNumber() {
        $year =  Carbon::now()->year;
        $number = Order::whereYear('created_at', $year)->max('number');
        if($number) {
            return $number + 1;
        }
        return $year . '0001';
    }
}
