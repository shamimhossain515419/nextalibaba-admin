<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'category_id','stock',
        'base_price', 'has_variant', 'sku', 'status', 'added_by'
    ];

    // Product belongs to user
    public function user() {
        return $this->belongsTo(User::class, 'added_by');
    }



    // Product belongs to many categories
    public function category() {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    // Product has many variants
    public function variants() {
        return $this->hasMany(ProductVariant::class);
    }
    // Product has many images
    public function images() {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    // Optional: get only the primary image
    public function primaryImage() {
        return $this->hasOne(ProductImage::class, 'product_id')->where('is_primary', 1);
    }

}
