<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        // Lấy danh mục cho filter
        $categories = Category::all();

        // Query sản phẩm
        $query = Product::with('category')->orderBy('created_at', 'desc');

        // Lọc danh mục
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Lọc trạng thái tồn kho
        if ($request->filled('status')) {
            if ($request->status === 'instock') {
                $query->where('stock', '>', 0);
            } elseif ($request->status === 'lowstock') {
                $query->whereBetween('stock', [1, 10]);
            } elseif ($request->status === 'outofstock') {
                $query->where('stock', 0);
            }
        }

        // Tìm kiếm
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        // Phân trang
        $products = $query->paginate(10)->withQueryString();

        // Trong method index()

        // Thống kê
        $totalProducts = Product::count();
        $totalCategories = Category::count();

        // Sản phẩm còn hàng (có ít nhất 1 variant stock_quantity > 0)
        $inStockProducts = Product::whereHas('variants', function ($q) {
            $q->where('stock_quantity', '>', 0);
        })->count();

        // Sản phẩm hết hàng (tất cả variant stock_quantity = 0)
        $outOfStockProducts = Product::whereDoesntHave('variants', function ($q) {
            $q->where('stock_quantity', '>', 0);
        })->orWhere(function ($q) {
            $q->whereDoesntHave('variants');
        })->count();

        // Sản phẩm sắp hết (có variant stock_quantity <= 10 và > 0)
        $lowStockProducts = Product::whereHas('variants', function ($q) {
            $q->where('stock_quantity', '>', 0)
                ->where('stock_quantity', '<=', 10);
        })->count();

        // ... phần còn lại giữ nguyên

        // Trong phần filter (lọc trạng thái tồn kho)
        if ($request->filled('status')) {
            if ($request->status === 'instock') {
                $query->whereHas('variants', function ($q) {
                    $q->where('stock_quantity', '>', 0);
                });
            } elseif ($request->status === 'lowstock') {
                $query->whereHas('variants', function ($q) {
                    $q->where('stock_quantity', '>', 0)
                        ->where('stock_quantity', '<=', 10);
                });
            } elseif ($request->status === 'outofstock') {
                $query->whereDoesntHave('variants', function ($q) {
                    $q->where('stock_quantity', '>', 0);
                })->orWhere(function ($q) {
                    $q->whereDoesntHave('variants');
                });
            }
        }

        return view('admin.products', compact(
            'products',
            'categories',
            'totalProducts',
            'inStockProducts',
            'outOfStockProducts',
            'totalCategories'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unit' => 'nullable|string',
            'description' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::create($request->except('images'));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unit' => 'nullable|string',
            'description' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product->update($request->except('images'));

        if ($request->hasFile('images')) {
            // Xóa ảnh cũ nếu cần
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.products')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Xóa sản phẩm thành công!');
    }
}