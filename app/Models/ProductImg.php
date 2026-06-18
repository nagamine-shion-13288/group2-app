<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImg extends Model
{
    // テーブル名が特殊なので、明示的に指定します
    protected $table = 'products_img';
}