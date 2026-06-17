<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ProductController extends Controller 
{ 
    public function products() { 
        
        return view('products'); 
    } 
}