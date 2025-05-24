<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'products';

    protected $fillable = [
        'name',
        'description',
        'image_url',
        'price',
        'stock_quantity',
        'category',
        'sub_category',
    ];

    protected $casts = [
        'price' => 'float',
        'stock_quantity' => 'integer',
    ];
}
?>