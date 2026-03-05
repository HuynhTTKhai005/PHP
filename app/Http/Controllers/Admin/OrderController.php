<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with(['user', 'payment'])->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = (string) $request->search;
            $query->where(function ($q) use ($search): void {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('shipping_name', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search): void {
                        $uq->where('full_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $orders = $query->paginate(20)->withQueryString();
        $orders->getCollection()->transform(function (Order $order): Order {
            $order->payment_status_text = $this->mapPaymentStatusText($order->payment?->status);
            $order->payment_status_class = $this->mapPaymentStatusClass($order->payment?->status);

            return $order;
        });

        $totalOrdersThisMonth = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $pendingOrders = Order::where('status', 'pending')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $processingOrders = Order::whereIn('status', ['confirmed', 'preparing', 'delivering'])
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $completedOrders = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view(
            'admin.orders',
            compact('orders', 'totalOrdersThisMonth', 'pendingOrders', 'processingOrders', 'completedOrders')
        );
    }

    public function show(Order $order): View
    {
        $order->load(['items.product', 'user', 'statusHistories']);

        return view('admin.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,delivering,completed,cancelled',
            'note' => 'nullable|string|max:500',
        ]);

        $newStatus = (string) $validated['status'];
        $oldStatus = (string) $order->status;

        if ($newStatus === $oldStatus) {
            return back()->with('success', 'Trạng thái đơn hàng không thay đổi.');
        }

        $order->update(['status' => $newStatus]);

        OrderStatusHistory::create([
            'order_id' => $order->id,
            'status' => $newStatus,
            'note' => $validated['note'] ?? null,
            'timestamp' => now(),
        ]);

        return back()->with('success', 'Cập nhật trạng thái thành công và đã lưu lịch sử.');
    }

    private function mapPaymentStatusText(?string $status): string
    {
        return $status === 'success' ? 'Đã thanh toán' : 'Chờ thanh toán';
    }

    private function mapPaymentStatusClass(?string $status): string
    {
        return $status === 'success' ? 'status-completed' : 'status-pending';
    }
}
