<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;


class Order extends Model
{
    // Mass assignable fields
    protected $fillable = [
        'quantity',
        'total',
        'shipping_cost',
        'notes',
        'payment_method',
        'customer_id',
        'status',
        'invoice'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

}
