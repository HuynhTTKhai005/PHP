<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CouponController extends Controller
{
    public function index(Request $request): View
    {
        return $this->renderIndex($request);
    }

    public function show(Request $request, Coupon $coupon): View
    {
        return $this->renderIndex($request, $coupon->id);
    }

    public function create(): View
    {
        return view('admin.coupon_create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePayload($request);

        Coupon::create($validated);

        return redirect()->route('admin.coupons')->with('success', 'Thêm mã giảm giá thành công.');
    }

    public function edit(Coupon $coupon): View
    {
        return view('admin.coupon_edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon): RedirectResponse
    {
        $validated = $this->validatePayload($request, $coupon->id);

        $coupon->update($validated);

        return redirect()->route('admin.coupons')->with('success', 'Cập nhật mã giảm giá thành công.');
    }

    public function destroy(Coupon $coupon): RedirectResponse
    {
        $coupon->delete();

        return redirect()->route('admin.coupons')->with('success', 'Xóa mã giảm giá thành công.');
    }

    public function toggleStatus(Coupon $coupon): RedirectResponse
    {
        $coupon->update([
            'is_active' => ! $coupon->is_active,
        ]);

        $message = $coupon->is_active ? 'Đã bật hoạt động mã giảm giá.' : 'Đã tắt hoạt động mã giảm giá.';

        return redirect()->back()->with('success', $message);
    }

    private function renderIndex(Request $request, ?int $showCouponId = null): View
    {
        $query = Coupon::query();

        if ($request->filled('type')) {
            $query->where('discount_type', $request->type);
        }

        if ($request->filled('search')) {
            $search = trim((string) $request->search);
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $status = (string) $request->get('status', '');
        if ($status === 'disabled') {
            $query->where('is_active', false);
        } elseif ($status === 'upcoming') {
            $query->where('is_active', true)->whereNotNull('starts_at')->where('starts_at', '>', now());
        } elseif ($status === 'expired') {
            $query->whereNotNull('expires_at')->where('expires_at', '<', now());
        } elseif ($status === 'active') {
            $query->where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
                })
                ->where(function ($q) {
                    $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
                });
        }

        $coupons = $query->latest('created_at')->paginate(10)->withQueryString();
        $coupons->getCollection()->transform(fn ($coupon) => $this->decorateCoupon($coupon));

        $allCoupons = Coupon::all()->map(fn ($coupon) => $this->decorateCoupon($coupon));
        $stats = [
            'total' => $allCoupons->count(),
            'active' => $allCoupons->where('status_key', 'active')->count(),
            'expired' => $allCoupons->where('status_key', 'expired')->count(),
            'upcoming' => $allCoupons->where('status_key', 'upcoming')->count(),
        ];

        $selectedCoupon = null;
        if ($showCouponId) {
            $selectedCoupon = Coupon::with(['orderCoupons.order'])
                ->whereKey($showCouponId)
                ->first();

            if ($selectedCoupon) {
                $selectedCoupon = $this->decorateCoupon($selectedCoupon);
            }
        }

        return view('admin.coupon', [
            'coupons' => $coupons,
            'stats' => $stats,
            'selectedCoupon' => $selectedCoupon,
        ]);
    }

    private function decorateCoupon(Coupon $coupon): Coupon
    {
        $coupon->status_key = $this->resolveStatus($coupon);

        $statusMap = [
            'active' => ['text' => 'Đang hoạt động', 'class' => 'status-active'],
            'expired' => ['text' => 'Đã hết hạn', 'class' => 'status-expired'],
            'upcoming' => ['text' => 'Sắp diễn ra', 'class' => 'status-upcoming'],
            'disabled' => ['text' => 'Đã vô hiệu hóa', 'class' => 'status-disabled'],
        ];

        $typeMap = [
            'percent' => ['text' => 'Phần trăm (%)'],
            'fixed' => ['text' => 'Cố định'],
        ];

        $coupon->status_text = $statusMap[$coupon->status_key]['text'];
        $coupon->status_class = $statusMap[$coupon->status_key]['class'];
        $coupon->type_text = $typeMap[$coupon->discount_type]['text'] ?? $coupon->discount_type;

        if ($coupon->discount_type === 'percent') {
            $coupon->discount_display = ((int) $coupon->discount_value).'%';
        } else {
            $coupon->discount_display = number_format((int) $coupon->discount_value, 0, ',', '.').'đ';
        }

        $limit = (int) ($coupon->usage_limit ?? 0);
        $used = (int) ($coupon->used_count ?? 0);
        $coupon->usage_display = $limit > 0 ? ($used.'/'.$limit) : ($used.'/∞');
        $coupon->usage_percentage = $limit > 0 ? min(100, (int) round(($used / max($limit, 1)) * 100)) : 0;

        return $coupon;
    }

    private function resolveStatus(Coupon $coupon): string
    {
        $now = now();

        if (! $coupon->is_active) {
            return 'disabled';
        }

        if ($coupon->starts_at && $coupon->starts_at->gt($now)) {
            return 'upcoming';
        }

        if ($coupon->expires_at && $coupon->expires_at->lt($now)) {
            return 'expired';
        }

        return 'active';
    }

    private function validatePayload(Request $request, ?int $ignoreId = null): array
    {
        $codeRule = 'required|string|max:50|unique:coupons,code';
        if ($ignoreId) {
            $codeRule .= ','.$ignoreId;
        }

        $data = $request->validate([
            'code' => $codeRule,
            'description' => 'nullable|string',
            'discount_type' => 'required|in:fixed,percent',
            'discount_value' => 'required|integer|min:0',
            'min_order_total_amount_cents' => 'nullable|integer|min:0',
            'max_discount_amount_cents' => 'nullable|integer|min:0',
            'usage_limit' => 'nullable|integer|min:0',
            'used_count' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        $data['code'] = strtoupper((string) $data['code']);
        $data['min_order_total_amount_cents'] = (int) ($data['min_order_total_amount_cents'] ?? 0);
        $data['used_count'] = (int) ($data['used_count'] ?? 0);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
