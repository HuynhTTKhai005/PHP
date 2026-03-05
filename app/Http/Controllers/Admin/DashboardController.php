<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $now = now();
        $month = (int) $now->month;
        $year = (int) $now->year;
        $previous = $now->copy()->subMonth();

        $totalRevenueThisMonth = Order::query()
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status', 'completed')
            ->sum('total_amount_cents');

        $previousMonthRevenue = Order::query()
            ->whereMonth('created_at', (int) $previous->month)
            ->whereYear('created_at', (int) $previous->year)
            ->where('status', 'completed')
            ->sum('total_amount_cents');

        $growthPercentage = $this->calculateGrowth($totalRevenueThisMonth, $previousMonthRevenue);
        $monthDisplay = 'Tháng '.$month.', '.$year;

        $totalOrdersThisMonth = Order::query()
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status', 'completed')
            ->count();

        $previousMonthOrders = Order::query()
            ->whereMonth('created_at', (int) $previous->month)
            ->whereYear('created_at', (int) $previous->year)
            ->where('status', 'completed')
            ->count();

        $ordersGrowth = $this->calculateGrowth($totalOrdersThisMonth, $previousMonthOrders);

        $topProducts = OrderItem::query()
            ->selectRaw('order_items.product_id, SUM(order_items.quantity) as total_sold, SUM(order_items.total_cents) as total_revenue')
            ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
            ->groupBy('order_items.product_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get()
            ->map(function (OrderItem $item): array {
                $stock = (int) optional($item->product)->stock;

                return [
                    'id' => (int) $item->product_id,
                    'name' => optional($item->product)->name ?: 'Sản phẩm đã xóa',
                    'sales' => (int) $item->total_sold,
                    'revenue' => (int) $item->total_revenue,
                    'stock' => $stock,
                    'stock_percent' => max(0, min(100, $stock)),
                ];
            });

        $recentCustomers = User::query()
            ->where('role_id', User::ROLE_CUSTOMER)
            ->withCount('orders')
            ->withSum('orders', 'total_amount_cents')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get()
            ->map(function (User $user): array {
                return [
                    'id' => (int) $user->id,
                    'name' => (string) $user->full_name,
                    'email' => (string) $user->email,
                    'orders' => (int) ($user->orders_count ?? 0),
                    'total' => (int) ($user->orders_sum_total_amount_cents ?? 0),
                    'time_ago' => $user->created_at?->diffForHumans() ?? '-',
                ];
            });

        $recentOrders = Order::query()
            ->orderByDesc('created_at')
            ->limit(8)
            ->get()
            ->map(function (Order $order): array {
                return [
                    'order_number' => $order->order_number ?: ('#'.str_pad((string) $order->id, 6, '0', STR_PAD_LEFT)),
                    'customer' => $order->shipping_name ?: 'Khách lẻ',
                    'date' => $order->created_at?->format('d/m/Y H:i') ?? '-',
                    'amount' => (int) $order->total_amount_cents,
                    'status' => (string) $order->status,
                ];
            });

        $recentActivities = $this->buildRecentActivities();

        return view('dashboard', [
            'totalRevenueThisMonth' => $totalRevenueThisMonth,
            'growthPercentage' => $growthPercentage,
            'totalOrdersThisMonth' => $totalOrdersThisMonth,
            'ordersGrowth' => $ordersGrowth,
            'recentOrders' => $recentOrders,
            'topProducts' => $topProducts,
            'recentCustomers' => $recentCustomers,
            'recentActivities' => $recentActivities,
            'monthDisplay' => $monthDisplay,
            'lastUpdatedAt' => $now->format('H:i:s d/m/Y'),
        ]);
    }

    public function revenueByMonth(): JsonResponse
    {
        $revenues = Order::query()
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount_cents) as total')
            ->whereYear('created_at', date('Y'))
            ->where('status', 'completed')
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month');

        return response()->json($revenues);
    }

    private function calculateGrowth(int|float $current, int|float $previous): float|int
    {
        if ($previous <= 0) {
            return $current > 0 ? 100 : 0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    private function buildRecentActivities(): array
    {
        $recentOrderActivities = Order::query()
            ->orderByDesc('created_at')
            ->limit(10)
            ->get()
            ->map(function (Order $order): array {
                $orderNumber = $order->order_number ?: ('#'.str_pad((string) $order->id, 6, '0', STR_PAD_LEFT));

                return [
                    'icon' => 'shopping-cart',
                    'title' => 'Đơn hàng mới '.$orderNumber,
                    'description' => 'Khách hàng: '.($order->shipping_name ?: 'Khách lẻ').
                        ' - Tổng: '.number_format((int) $order->total_amount_cents, 0, ',', '.').'đ',
                    'time_ago' => $order->created_at?->diffForHumans() ?? '-',
                    'timestamp' => $order->created_at?->getTimestamp() ?? 0,
                ];
            });

        $recentUserActivities = User::query()
            ->where('role_id', '!=', User::ROLE_ADMIN)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get()
            ->map(function (User $user): array {
                return [
                    'icon' => 'user-plus',
                    'title' => 'Khách hàng mới đăng ký',
                    'description' => $user->full_name.' - '.$user->email,
                    'time_ago' => $user->created_at?->diffForHumans() ?? '-',
                    'timestamp' => $user->created_at?->getTimestamp() ?? 0,
                ];
            });

        $recentProductActivities = Product::query()
            ->with('category')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get()
            ->map(function (Product $product): array {
                return [
                    'icon' => 'box',
                    'title' => 'Sản phẩm mới được thêm',
                    'description' => $product->name.' - Danh mục: '.($product->category?->name ?: 'Không rõ'),
                    'time_ago' => $product->created_at?->diffForHumans() ?? '-',
                    'timestamp' => $product->created_at?->getTimestamp() ?? 0,
                ];
            });

        return $recentOrderActivities
            ->merge($recentUserActivities)
            ->merge($recentProductActivities)
            ->sortByDesc('timestamp')
            ->take(8)
            ->values()
            ->all();
    }
}
