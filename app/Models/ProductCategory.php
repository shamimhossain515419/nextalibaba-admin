<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    use HasFactory;
     protected $connection = 'mongodb';
    protected $collection = 'product_categories';

    // Mass assignable fields
    protected $fillable = [
        'name',
        'slug',
        'image',
        'added_by',
    ];
    protected static function booted()
    {
        static::creating(function ($model) {
            if (auth()->check()) {
                $user = auth()->user();
                $model->added_by = $user->id;
            }
            // Auto-generate slug if not set
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
