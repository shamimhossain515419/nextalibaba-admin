<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'company',
        'country',
        'address',
        'city',
        'state',
        'zip',
        'phone',
        'email',
        'customer_id',
    ];
    public function customer(){
        return $this->belongsTo(User::class, 'customer_id');
    }
}
