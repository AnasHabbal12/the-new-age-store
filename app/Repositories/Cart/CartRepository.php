<?php 

namespace App\Repositories\Cart;

use Illuminate\Support\Collection;
use App\Models\Product;

interface CartRepository {
    public function get() : Collection;

    public function add(Product $item, $quantity = 1);

    public function update($id, $quantity);

    public function delete($id);

    public function empty();

    public function total() : float;
}