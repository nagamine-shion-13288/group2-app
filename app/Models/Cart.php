<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Cart extends Model
{
    /**
     * 複合主キーのため incrementing を無効化
     */
    public $incrementing = false;

    /**
     * 一括代入可能なカラム
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    /**
     * ユーザーとのリレーション
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 商品とのリレーション（仮）
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo('App\Models\Product');
    }
}