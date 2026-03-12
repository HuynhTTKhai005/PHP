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
    public function index(Request $request): View|\Illuminate\Http\JsonResponse
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
            $order->payment_method_text = $this->mapPaymentMethodText($order->payment?->payment_method);

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

        if ($request->expectsJson()) {
            $html = view('admin.partials.orders_table', compact('orders'))->render();

            return response()->json([
                'status' => 'success',
                'html' => $html,
            ]);
        }

        return view('admin.orders', compact('orders', 'totalOrdersThisMonth', 'pendingOrders', 'processingOrders', 'completedOrders'));
    }

    public function show(Order $order): View
    {
        $order->load(['items.product', 'user', 'statusHistories']);

        return view('admin.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,delivering,completed,cancel_requested,cancelled',
            'note' => 'nullable|string|max:500',
        ]);

        $newStatus = (string) $validated['status'];
        $oldStatus = (string) $order->status;

        if ($newStatus === $oldStatus) {
            $message = 'Trạng thái đơn hàng không thay đổi.';

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => $message,
                ]);
            }

            return back()->with('success', $message);
        }

        $order->update(['status' => $newStatus]);

        OrderStatusHistory::create([
            'order_id' => $order->id,
            'status' => $newStatus,
            'note' => $validated['note'] ?? null,
            'timestamp' => now(),
        ]);

        $message = 'Cập nhật trạng thái thành công và đã lưu lịch sử.';

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }

    private function mapPaymentMethodText(?string $method): string
    {
        return match ($method) {
            'cash' => 'Tiền mặt (COD)',
            'bank_transfer' => 'Chuyển khoản ngân hàng',
            'online' => 'Thanh toán online',
            default => 'Tiền mặt (COD)',
        };
    }
}