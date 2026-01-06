<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;


class ProductImage extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'image', 'is_primary'];

    // Each image belongs to a single product
    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
