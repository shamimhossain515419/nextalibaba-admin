<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class OrderLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'total',
        'notes',
        'product_id',
        'order_id'
    ];
    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
