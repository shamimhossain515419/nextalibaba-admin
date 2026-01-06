<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;



class FeaturesProduct extends Model
{
    use HasFactory;

    protected $fillable = ['product_id','features_category_id'];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function features_category(){
        return $this->belongsTo(FeaturesCategory::class, 'features_category_id');
    }

}
