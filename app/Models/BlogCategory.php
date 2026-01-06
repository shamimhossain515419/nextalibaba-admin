<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;


class BlogCategory extends Model
{
    use HasFactory;
    // Mass assignable fields
    protected $fillable = [
        'name',
        'slug'
    ];
}
