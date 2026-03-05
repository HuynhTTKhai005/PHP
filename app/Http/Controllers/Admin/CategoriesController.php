<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoriesController extends Controller
{
    public function index(Request $request): View
    {
        $query = Category::query()
            ->withCount('products')
            ->with('parent')
            ->latest('id');

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('search')) {
            $search = trim((string) $request->search);
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $categories = $query->paginate(10)->withQueryString();

        $stats = [
            'total' => Category::count(),
            'active' => Category::where('is_active', true)->count(),
            'inactive' => Category::where('is_active', false)->count(),
        ];

        return view('admin.categories', compact('categories', 'stats'));
    }

    public function create(): View
    {
        $parents = Category::orderBy('name')->get();

        return view('admin.categories_create', compact('parents'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatePayload($request);

        Category::create($data);

        return redirect()->route('admin.categories')->with('success', 'Thêm danh mục thành công.');
    }

    public function edit(Category $category): View
    {
        $parents = Category::where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();

        return view('admin.categories_edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $this->validatePayload($request, $category->id);

        $category->update($data);

        return redirect()->route('admin.categories')->with('success', 'Cập nhật danh mục thành công.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $hasProducts = Product::where('category_id', $category->id)->exists();
        if ($hasProducts) {
            return back()->with('error', 'Không thể xóa danh mục đang có sản phẩm.');
        }

        if (Category::where('parent_id', $category->id)->exists()) {
            return back()->with('error', 'Không thể xóa danh mục đang có danh mục con.');
        }

        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Xóa danh mục thành công.');
    }

    private function validatePayload(Request $request, ?int $ignoreId = null): array
    {
        $slugRule = 'nullable|string|max:255|unique:categories,slug';
        if ($ignoreId) {
            $slugRule .= ','.$ignoreId;
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => $slugRule,
            'parent_id' => 'nullable|exists:categories,id',
            'is_active' => 'nullable|boolean',
        ]);

        $data['slug'] = $data['slug']
            ? Str::slug((string) $data['slug'])
            : Str::slug((string) $data['name']);

        $data['is_active'] = (bool) $request->boolean('is_active');

        return $data;
    }
}
