<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    // ★「商品1つに対して、画像は複数存在する可能性がある（1対多）」というつながりを定義します
    public function images()
    {
        return $this->hasMany(ProductImg::class, 'product_id', 'id');
    }
    // app/Models/Product.php の中身

public function shop()
{
    // 商品は特定の1つのショップに所属する
    return $this->belongsTo(Shop::class);
}
}