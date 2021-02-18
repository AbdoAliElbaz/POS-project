<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
    
        'name',
        'category_id',
        'user_id',
        'description',
        'image',
        'quantity',
        'price',
        'reorder_point',
    ];
}
