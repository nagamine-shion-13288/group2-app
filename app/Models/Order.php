<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'total_price', 'status', 'shipping_name', 'shipping_address', 'shipping_phone', 'shipping_fee'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}