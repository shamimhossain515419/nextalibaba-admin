<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;


class Attribute extends Model
{
    use HasFactory;

    protected $fillable = ['name','variant_id'];
    public function variant(){
        return $this->belongsTo(Variant::class, 'variant_id');
    }
}
