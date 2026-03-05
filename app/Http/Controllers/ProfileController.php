<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function profile(Request $request): View
    {
        $user = $request->user()->load([
            'addresses' => function ($query): void {
                $query->where('is_default', true);
            },
        ]);

        $defaultAddress = $user->addresses->first();

        return view('frontend.profile', [
            'user' => $user,
            'defaultAddress' => $defaultAddress,
        ]);
    }

    public function myOrders(Request $request): View
    {
        $orders = $request->user()->orders()
            ->with('payment')
            ->withCount('items')
            ->when($request->filled('status'), function ($query) use ($request): void {
                $query->where('status', $request->status);
            })
            ->when($request->filled('search'), function ($query) use ($request): void {
                $search = trim((string) $request->search);
                $query->where('order_number', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $orders->getCollection()->transform(function (Order $order): Order {
            $order->payment_status_text = $order->payment?->status === 'success'
                ? 'Đã thanh toán'
                : 'Chờ thanh toán';

            return $order;
        });

        return view('frontend.my_orders', compact('orders'));
    }

    public function myOrderShow(Request $request, Order $order): View
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        $order->load(['items.product', 'payment', 'coupon.coupon']);
        $order->payment_status_text = $order->payment?->status === 'success'
            ? 'Đã thanh toán'
            : 'Chờ thanh toán';

        return view('frontend.my_order_show', compact('order'));
    }

    public function cancelMyOrder(Request $request, Order $order): RedirectResponse
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        if (! in_array($order->status, ['pending', 'confirmed'], true)) {
            return back()->with('error', 'Đơn hàng không thể hủy ở trạng thái hiện tại.');
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Hủy đơn hàng thành công.');
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user->full_name = $request->full_name;
        $user->phone = $request->phone;

        $user->save();

        return redirect()->route('profile')->with('status', 'Thông tin đã được cập nhật thành công.');
    }

    public function changePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->update([
            'password_hash' => Hash::make($request->password),
        ]);

        return back()->with('status', 'Mật khẩu đã được thay đổi.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
