<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('id')->get();
        $query = Product::with('category')->where('is_available', true);
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        $products = $query->paginate(6);
        return view('frontend.menu', compact('categories', 'products'));
    }
}
