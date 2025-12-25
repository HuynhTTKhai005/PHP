<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class MenuController extends Controller
{
    public function index()
    {

        $categories = Category::orderBy('id')->get();
        $products = Product::with('category')
            ->where('is_available', true)
            ->get();

        return view('frontend.menu', compact('categories', 'products'));
    }
}