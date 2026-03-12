<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Http\JsonResponse;
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
            $order->payment_method_text = $this->mapPaymentMethodText($order->payment?->payment_method);

            return $order;
        });

        return view('frontend.my_orders', compact('orders'));
    }

    public function myOrderShow(Request $request, Order $order): View
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        $order->load(['items.product', 'payment', 'coupon.coupon']);
        $order->payment_method_text = $this->mapPaymentMethodText($order->payment?->payment_method);

        return view('frontend.my_order_show', compact('order'));
    }

    public function cancelMyOrder(Request $request, Order $order): RedirectResponse|JsonResponse
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        if (! in_array($order->status, ['pending', 'confirmed'], true)) {
            return $this->respondCancel(
                $request,
                'Đơn hàng không thể yêu cầu hủy ở trạng thái hiện tại.',
                'error',
                422
            );
        }

        if ($order->status === 'cancel_requested') {
            return $this->respondCancel($request, 'Đơn hàng đã được gửi yêu cầu hủy.', 'error', 422);
        }

        $order->update(['status' => 'cancel_requested']);
        OrderStatusHistory::create([
            'order_id' => $order->id,
            'status' => 'cancel_requested',
            'note' => 'Yêu cầu hủy từ khách hàng',
            'timestamp' => now(),
        ]);

        return $this->respondCancel(
            $request,
            'Đã gửi yêu cầu hủy. Vui lòng chờ admin xác nhận.',
            'success'
        );
    }

    private function respondCancel(
        Request $request,
        string $message,
        string $status,
        int $code = 200
    ): RedirectResponse|JsonResponse {
        if ($request->expectsJson()) {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'order_status' => 'cancel_requested',
                'order_status_text' => 'Chờ duyệt hủy',
            ], $code);
        }

        return back()->with($status, $message);
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

    public function notifications(Request $request): View
    {
        $user = $request->user();
        $orderIds = $user->orders()->select('id');

        $notifications = OrderStatusHistory::query()
            ->with('order')
            ->whereIn('order_id', $orderIds)
            ->orderByDesc('timestamp')
            ->limit(30)
            ->get();

        return view('frontend.notifications', compact('notifications'));
    }
}
