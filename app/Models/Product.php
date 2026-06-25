<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    public function images()
    {
        return $this->hasMany(ProductImg::class, 'product_id', 'id');
    }
public function shop()
{
    return $this->belongsTo(Shop::class);
}
    protected $fillable = [
        'shop_id', 
        'name', 
        'description', 
        'category_id', 
        'price', 
        'stock',
        'voice_url',
    ];
}