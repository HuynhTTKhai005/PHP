<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(Request $request): View
    {
        $wishlists = $request->user()
            ->wishlists()
            ->with(['product.category'])
            ->latest('created_at')
            ->paginate(12);

        return view('frontend.wishlist', compact('wishlists'));
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        Wishlist::firstOrCreate([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
        ], [
            'created_at' => now(),
        ]);

        return back()->with('success', 'Đã thêm sản phẩm vào danh sách yêu thích.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        Wishlist::query()
            ->where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->delete();

        return back()->with('success', 'Đã xóa sản phẩm khỏi danh sách yêu thích.');
    }
}
