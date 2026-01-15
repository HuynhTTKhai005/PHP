<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Lấy tháng và năm hiện tại (hoặc bạn có thể truyền từ request để chọn tháng khác)
        $month = Carbon::now()->month;
        $year  = Carbon::now()->year;

        // Tổng doanh thu tháng hiện tại (chỉ tính đơn hoàn thành)
        $totalRevenueThisMonth = Order::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status', 'pending')
            ->sum('total_amount_cents');

        // Tổng doanh thu tháng trước (để tính % tăng/giảm)
        $previousMonthRevenue = Order::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->where('status', 'pending')
            ->sum('total_amount_cents');

        // Tính phần trăm thay đổi
        $growthPercentage = $previousMonthRevenue > 0
            ? round((($totalRevenueThisMonth - $previousMonthRevenue) / $previousMonthRevenue) * 100, 1)
            : ($totalRevenueThisMonth > 0 ? 100 : 0);

        // Định dạng hiển thị tháng 
        $monthDisplay = 'Tháng ' . $month . ', ' . $year;

        // === THÊM MỚI: Tổng số đơn hàng hoàn thành trong tháng ===
        $totalOrdersThisMonth = Order::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status', 'pending')
            ->count();

        // Tính % tăng/giảm số đơn hàng so với tháng trước (tùy chọn)
        $previousMonthOrders = Order::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->where('status', 'pending')
            ->count();

        $ordersGrowth = $previousMonthOrders > 0
            ? round((($totalOrdersThisMonth - $previousMonthOrders) / $previousMonthOrders) * 100, 1)
            : ($totalOrdersThisMonth > 0 ? 100 : 0);

        $newCustomersThisMonth = User::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('role_id', 'customer')  // nếu bạn có cột role
            // Nếu không có role, bỏ dòng này hoặc thêm điều kiện khác
            ->count();

        $previousMonthCustomers = User::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->where('role_id', 'customer')
            ->count();

        $customersGrowth = $previousMonthCustomers > 0
            ? round((($newCustomersThisMonth - $previousMonthCustomers) / $previousMonthCustomers) * 100, 1)
            : ($newCustomersThisMonth > 0 ? 100 : 0);

        // Đơn hàng gần đây
        $recent_orders = Order::orderBy('created_at', 'desc')
            ->limit(8)
            ->get()
            ->map(function ($order) {
                return [
                    'id'           => $order->id,
                    'order_number' => $order->order_number
                        ?? '#' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
                    'customer'     => $order->shipping_name ?: 'Khách lẻ',
                    'date'         => $order->created_at->format('d/m/Y H:i'),
                    'amount'       => $order->total_amount_cents,
                    'status'       => $order->status,
                ];
            });





        return view('dashboard', compact(
            'totalRevenueThisMonth',
            'growthPercentage',
            'totalOrdersThisMonth',
            'ordersGrowth',
            'recent_orders',
            // 'newCustomersThisMonth',
            // 'customersGrowth',
            'monthDisplay'

        ));
    }
}