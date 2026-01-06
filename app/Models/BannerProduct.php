<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;


class BannerProduct extends Model
{
    use HasFactory;

    protected $fillable = ['name','product_id'];
    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
