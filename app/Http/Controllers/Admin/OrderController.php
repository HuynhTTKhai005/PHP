<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Danh sách đơn hàng admin
     */
    public function index(Request $request)
    {
        $query = Order::with(['user'])->orderBy('created_at', 'desc');

        // Lọc theo trạng thái
        if ($request->filled('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Lọc theo ngày
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Tìm kiếm theo mã đơn hoặc tên khách
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('order_number', 'like', "%{$search}%")
                    ->orWhere('shipping_name', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('full_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Phân trang
        $orders = $query->paginate(20)->withQueryString();

        // Thống kê nhanh
        $totalOrdersThisMonth = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $pendingOrders = Order::where('status', 'pending')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $processingOrders = Order::where('status', 'processing')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $completedOrders = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('admin.orders', compact('orders', 'totalOrdersThisMonth', 'pendingOrders', 'processingOrders', 'completedOrders'));
    }

    /**
     * Xem chi tiết đơn hàng
     */
    public function show(Order $order)
    {
        $order->load(['items.product', 'user']);
        return view('admin.show', compact('order'));
    }

    /**
     * Hiển thị form tạo đơn hàng mới
     */
    public function create()
    {
        // Có thể load danh sách sản phẩm, khách hàng nếu cần
        return view('admin.orders.create');
    }

    /**
     * Lưu đơn hàng mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price_cents' => 'required|integer|min:0',
        ]);

        // Tạo đơn hàng
        $order = Order::create([
            'order_number' => 'ORD-' . time() . '-' . rand(100, 999),
            'status' => 'pending',
            'shipping_name' => $request->shipping_name,
            'shipping_phone' => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'total_amount_cents' => 0, // Tính sau
            'subtotal_cents' => 0,
        ]);

        $total = 0;
        foreach ($request->items as $itemData) {
            $itemTotal = $itemData['quantity'] * $itemData['price_cents'];
            $total += $itemTotal;

            $order->items()->create([
                'product_id' => $itemData['product_id'],
                'quantity' => $itemData['quantity'],
                'unit_price_cents' => $itemData['price_cents'],
                'total_cents' => $itemTotal,
            ]);
        }

        $order->update([
            'total_amount_cents' => $total,
            'subtotal_cents' => $total,
        ]);

        return redirect()->route('admin.orders')->with('success', 'Đơn hàng đã được tạo thành công!');
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Cập nhật trạng thái thành công!');
    }
}