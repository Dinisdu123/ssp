<?php
namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $connection = 'mongodb';
    protected $collection = 'products';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'description', 'image_url', 'price', 'stock_quantity', 'category', 'sub_category',
    ];

    protected $casts = [
        'price' => 'float',
        'stock_quantity' => 'integer',
    ];

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeBySubCategory($query, $subCategory)
    {
        return $query->where('sub_category', $subCategory);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function getFormattedPriceAttribute()
    {
        return 'LKR ' . number_format($this->price, 2);
    }
}