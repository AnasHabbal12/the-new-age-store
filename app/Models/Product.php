<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Models\Scopes\StoreScope;
use App\Models\Category;
use App\Models\Store;
use App\Models\Tag;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'img', 'category_id', 'price', 'compare_price',
         'store_id', 'status', 
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at', 'img'
    ];

    protected $appends = ['img_url',];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function store() {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    protected static function booted() {
        static::addGlobalScope('store', new StoreScope());
        static::creating(function(Product $product) {
            $product->slug = Str::slug($product->name);
        });
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'product_tag', 'product_id', 'tag_id', 'id', 'id');
    }

    public function scopeActive(Builder $builder) {
        $builder->where('status', '=', 'active');
    }

    public function getImgUrlAttribute () {
        if (!$this->img)
            return 'https://app.advaiet.com/item_dfile/default_product.png';
        if (Str::startsWith($this->img, ['http://', 'https://']))
            return $this->img;
        return asset('storage/', $this->img);
    }

    public function getSellPercentAttribute () {
        if(!$this->compare_price) {
            return 0;
        }
        return number_format(100 - (100 *$this->price / $this->compare_price),0);
    }

    public function scopeFilter (Builder $builder, $filters) {
        $options = array_merge([
            'store_id' => null, 
            'category_id' => null,
            'tag_id' => null, 
            'status' => 'active'
        ], $filters);

        $builder->when($options['status'], function($builder, $value) {
            $builder->where('status', $value);
        });

        $builder->when($options['store_id'], function($builder, $value) {
            $builder->where('store_id', $value);
        });

        $builder->when($options['category_id'], function($builder, $value) {
            $builder->where('store_id', $value);
        });

        $builder->when($options['tag_id'], function($builder, $value) {
            $builder->whereExists(function($query) use ($value) {
                $query->select(1)->from('product_tag')->whereRaw('product_id = products.id')->where('tag-id', $value);
            });
        });

        //طرق مختلفة
        /*$builder->whereRaw('id IN (SELECT product_id FROM product_tag WHERE tag_id = ? )', [$value]);
        $builder->whereRaw('EXISTS IN (SELECT 1 FROM product_tag WHERE tag_id = ? AND product_id = products.id)', [$value]);*/ 
        /*$builder->when($options['tag_id'], function($builder, $value) {
            $builder->whereHas('tags', function($builder) use ($value) {
                $builder->where('id', $value);
            });
        });*/  

    }

}