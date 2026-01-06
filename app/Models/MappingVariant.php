<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;



class MappingVariant extends Model
{
    use HasFactory;

    protected $fillable = ['product_id','attribute_id','variant_id'];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function attribute(){
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
    public function variant(){
        return $this->belongsTo(Variant::class, 'variant_id');
    }

}
