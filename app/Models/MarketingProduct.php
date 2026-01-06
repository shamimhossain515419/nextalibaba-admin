<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;




class MarketingProduct extends Model
{
    use HasFactory;
    protected $fillable = ['name','title','category_id','image'];

    public function category(){
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
}
