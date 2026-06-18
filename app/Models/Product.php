<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    // ★「商品1つに対して、画像は複数存在する可能性がある（1対多）」というつながりを定義します
    public function images()
    {
        return $this->hasMany(ProductImg::class, 'product_id', 'id');
    }
}