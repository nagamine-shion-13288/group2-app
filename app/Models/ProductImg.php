<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImg extends Model
{
    protected $table = 'products_img';
    protected $fillable = [
        'product_id', 
        'url', 
        'alt'
    ];
}