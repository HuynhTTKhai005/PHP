<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\InventoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProductsController extends Controller
{
    public function __construct(private readonly InventoryService $inventoryService) {}

    public function index(Request $request): View
    {
        $categories = Category::all();
        $query = Product::with('category')->orderByDesc('created_at');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            if ($request->status === 'instock') {
                $query->where('stock', '>', 10);
            } elseif ($request->status === 'lowstock') {
                $query->whereBetween('stock', [1, 10]);
            } elseif ($request->status === 'outofstock') {
                $query->where('stock', 0);
            }
        }

        if ($request->filled('search')) {
            $search = (string) $request->search;
            $query->where(fn($q) => $q->where('name', 'like', "%{$search}%"));
        }

        $products = $query->paginate(10)->withQueryString();
        $pagination = [
            'from' => $products->firstItem() ?? 0,
            'to' => $products->lastItem() ?? 0,
            'total' => $products->total(),
        ];

        $products->getCollection()->transform(function (Product $product): Product {
            $stock = (int) $product->stock;
            $product->stock_status = $stock > 10 ? 'instock' : ($stock > 0 ? 'lowstock' : 'outofstock');
            $product->stock_text = $stock > 10 ? 'Còn hàng' : ($stock > 0 ? 'Sắp hết' : 'Hết hàng');
            $product->progress_width = $stock > 0 ? min(100, $stock) : 0;

            return $product;
        });

        $totalProducts = Product::count();
        $inStockProducts = Product::where('stock', '>', 10)->count();
        $lowStockProducts = Product::whereBetween('stock', [1, 10])->count();
        $outOfStockProducts = Product::where('stock', 0)->count();
        $totalCategories = Category::count();

        return view('admin.products', compact(
            'products',
            'pagination',
            'categories',
            'totalProducts',
            'inStockProducts',
            'outOfStockProducts',
            'lowStockProducts',
            'totalCategories'
        ));
    }

    public function show(Product $product): View
    {
        $product->load('category', 'variants');
        $defaultVariant = $product->variants->sortBy('id')->first();

        return view('admin.products_show', compact('product', 'defaultVariant'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products_create', compact('categories'));
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products_edit', compact('product', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'base_price_cents' => 'required_without:price|integer|min:0',
            'price' => 'required_without:base_price_cents|integer|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'type' => 'nullable|in:food,drink',
            'is_spicy' => 'nullable|boolean',
            'is_available' => 'nullable|boolean',
        ]);

        $basePriceCents = (int) ($request->base_price_cents ?? $request->price);
        $imageUrl = $request->image_url;

        if ($request->hasFile('image_file')) {
            $storedPath = $request->file('image_file')->store('products', 'public');
            $imageUrl = 'storage/' . $storedPath;
        }

        DB::transaction(function () use ($request, $basePriceCents, $imageUrl): void {
            $initialStock = (int) $request->stock;

            $product = Product::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'category_id' => $request->category_id,
                'base_price_cents' => $basePriceCents,
                'stock' => 0,
                'description' => $request->description,
                'image_url' => $imageUrl,
                'type' => $request->type,
                'is_spicy' => (bool) $request->boolean('is_spicy'),
                'is_available' => (bool) $request->boolean('is_available', true),
            ]);

            if ($initialStock > 0) {
                $this->inventoryService->stockIn(
                    $product,
                    $initialStock,
                    'initial_stock',
                    'Nhập kho ban đầu khi tạo sản phẩm'
                );
            }
        });

        return redirect()->route('admin.products')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'base_price_cents' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'type' => 'nullable|in:food,drink',
            'is_spicy' => 'nullable|boolean',
            'is_available' => 'nullable|boolean',
        ]);

        $imageUrl = $request->image_url;
        if ($request->hasFile('image_file')) {
            $storedPath = $request->file('image_file')->store('products', 'public');
            $imageUrl = 'storage/' . $storedPath;
        }

        DB::transaction(function () use ($request, $product, $imageUrl): void {
            $targetStock = (int) $request->stock;
            $variant = $product->variants()->orderBy('id')->first();

            if (! $variant) {
                $variant = $product->variants()->create([
                    'sku' => 'SKU-' . $product->id . '-' . now()->timestamp,
                    'name' => 'Mặc định',
                    'price_adjustment' => 0,
                    'stock_quantity' => 0,
                ]);
            }

            $variant->update(['stock_quantity' => $targetStock]);

            $product->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'category_id' => $request->category_id,
                'base_price_cents' => $request->base_price_cents,
                'stock' => $targetStock,
                'description' => $request->description,
                'image_url' => $imageUrl,
                'type' => $request->type,
                'is_spicy' => (bool) $request->boolean('is_spicy'),
                'is_available' => (bool) $request->boolean('is_available'),
            ]);
        });

        return redirect()->route('admin.products')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function stockIn(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:100000',
            'reason' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:500',
        ]);

        try {
            DB::transaction(function () use ($product, $validated): void {
                $this->inventoryService->stockIn(
                    $product,
                    (int) $validated['quantity'],
                    $validated['reason'] ?? 'stock_in',
                    $validated['note'] ?? null
                );
            });
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }

        return back()->with('success', 'Nhập kho thành công.');
    }

    public function toggleAvailability(Product $product): RedirectResponse
    {
        $product->update([
            'is_available' => ! $product->is_available,
        ]);

        $message = $product->is_available
            ? 'Đã bật trạng thái còn bán cho sản phẩm.'
            : 'Đã tắt trạng thái còn bán cho sản phẩm.';

        return back()->with('success', $message);
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Xóa sản phẩm thành công!');
    }
}
