<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Rules\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'parent_id', 'description', 'img', 'slug', 'status'];

    // protected $guarded = ['id']; ممنوع ارساله

    public function products() {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function parent() {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function child() {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function scopeFilter(Builder $builder, $filter) {

        $builder->when($filter['name'] ?? false , function($builder, $value) { 
            $builder-> where ('categories.name', 'LIKE', "%{$value}%");
        } );
        $builder->when($filter['status'] ?? false , function($builder, $value) { 
            $builder-> where ('categories.status', '=', "{$value}");
        } );
    //     if ($filter['name'] ?? false ) {
    //         $builder-> where ('categories.name', 'LIKE', "%{$filter['name']}%");
    //     }
    //     if ( $filter['status'] ?? false) {
    //         $builder-> where ('categories.status',  $filter['status']);
    //     }
    }



    public static function rules($id = 0) {
        return [
            'name' => ['required', 
            'string', 
            'min:3', 
            'max:254', 
            "unique:categories,name,$id", 
            /*function($attribute, $value, $fails) {
                if($value == 'laravel') {
                    $fails('this name is frorbidden!');
                }
            }],*/
            //'filter:laravel',],
            new Filter(),],
            'parent_id' => ['nullable', 'int', 'exists:categories,id'],
            'img' => ['image', 'max:2148999', 'dimensions:min_width=100,min_height:100'],
            'status' => 'required|in:active,archived',
        ];
    }
}
