<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'title',
        'slug',
        'image',
        'content',
        'category_id',
        'author',
        'status',
    ];
    public function category(){
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }
    public function author(){
        return $this->belongsTo(User::class, 'author');
    }

}
