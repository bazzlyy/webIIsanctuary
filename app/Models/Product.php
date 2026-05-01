<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

public function sizes()
{
    return $this->hasMany(ProductSize::class);
    return $this->hasMany(\App\Models\ProductSize::class);
}
    protected $fillable = [
    'name',
    'price',
    'description',
    'stock',
    'image'
];
}
