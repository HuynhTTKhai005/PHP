<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)
            ->orderBy('id')
            ->get();

        $query = Product::with('category')
            ->where('is_available', true)
            ->whereHas('category', function ($q): void {
                $q->where('is_active', true);
            });

        if ($request->filled('search')) {
            $searchTerm = (string) $request->search;
            $query->where('name', 'like', "%{$searchTerm}%");
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request): void {
                $q->where('slug', $request->category)
                    ->where('is_active', true);
            });
        }

        $products = $query->paginate(6)->withQueryString();

        $wishlistProductIds = [];
        if ($request->user()) {
            $wishlistProductIds = $request->user()
                ->wishlists()
                ->pluck('product_id')
                ->all();
        }

        return view('frontend.menu', compact('categories', 'products', 'wishlistProductIds'));
    }

    public function show(Request $request, Product $product)
    {
        $product->load('category');

        if (
            ! $product->is_available
            || ! $product->category
            || ! $product->category->is_active
        ) {
            abort(404);
        }

        $isWishlisted = false;
        if ($request->user()) {
            $isWishlisted = $request->user()
                ->wishlists()
                ->where('product_id', $product->id)
                ->exists();
        }

        return view('frontend.product_detail', compact('product', 'isWishlisted'));
    }
}