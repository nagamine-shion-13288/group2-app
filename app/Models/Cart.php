<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Account;
use App\Models\Product;

class Cart extends Model
{

    //カートにタイムスタンプ機能は実装してないので無効化
    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * 商品とのリレーション
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}