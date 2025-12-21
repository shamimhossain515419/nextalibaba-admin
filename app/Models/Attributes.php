<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attributes extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function values()
    {
        return $this->hasMany(AttributeValues::class);
    }
}
