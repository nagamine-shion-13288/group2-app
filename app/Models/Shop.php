<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $table = 'shops';

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function managers()
    {
        return $this->hasMany(ShopManager::class, 'shop_id', 'id');
    }
}