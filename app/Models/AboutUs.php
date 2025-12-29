<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'support_email',
        'facebook',
        'twitter',
        'linkedin',
        'youtube',
        'footer_logo',
        'navbar_logo',
        'favicon',
        'about_info'
    ];

}
