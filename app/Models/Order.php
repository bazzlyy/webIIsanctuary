<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{



    public function items()
{
    return $this->hasMany(OrderItem::class);
}

    protected $fillable = [
    'user_id', // WAJIB ADA
    'name',
    'address',
    'phone',
    'total',
    'status'
];


}
