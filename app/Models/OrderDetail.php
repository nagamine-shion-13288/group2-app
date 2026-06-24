<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';

    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'price', 'delivery_status'
    ];

    // 親の注文テーブル（orders）との連携
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // 商品テーブル（products）との連携
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}