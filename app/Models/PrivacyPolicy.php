<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;


class PrivacyPolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
    ];
}
