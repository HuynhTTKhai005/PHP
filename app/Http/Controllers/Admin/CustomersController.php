<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class CustomersController extends Controller
{
    public function index(Request $request): View
    {
        return $this->renderIndex($request);
    }

    public function show(Request $request, User $customer): View
    {
        return $this->renderIndex($request, $customer->id);
    }

    public function create(): View
    {
        return view('admin.customers_create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'is_active' => 'nullable|boolean',
            'address' => 'nullable|string|max:500',
        ]);

        $customer = User::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password_hash' => Hash::make($validated['password']),
            'role_id' => $this->getCustomerRoleId(),
            'loyalty_point' => 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        $this->savePrimaryAddress($customer, $validated['address'] ?? null);

        return redirect()->route('admin.customers')->with('success', 'Thêm khách hàng thành công.');
    }

    public function edit(User $customer): View
    {
        $customer->load('addresses');

        return view('admin.customers_edit', [
            'customer' => $customer,
            'address' => optional($customer->addresses->first())->address_detail,
        ]);
    }

    public function update(Request $request, User $customer): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'is_active' => 'nullable|boolean',
            'address' => 'nullable|string|max:500',
        ]);

        $payload = [
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ];

        if (! empty($validated['password'])) {
            $payload['password_hash'] = Hash::make($validated['password']);
        }

        $customer->update($payload);
        $this->savePrimaryAddress($customer, $validated['address'] ?? null);

        return redirect()->route('admin.customers')->with('success', 'Cập nhật khách hàng thành công.');
    }

    public function destroy(User $customer): RedirectResponse
    {
        if (Schema::hasColumn('users', 'deleted_at')) {
            DB::table('users')
                ->where('id', $customer->id)
                ->update([
                    'deleted_at' => now(),
                    'updated_at' => now(),
                ]);
        } else {
            $customer->delete();
        }

        return redirect()->route('admin.customers')->with('success', 'Xóa khách hàng thành công.');
    }

    private function renderIndex(Request $request, ?int $showCustomerId = null): View
    {
        $query = $this->baseCustomersQuery();

        $search = trim((string) $request->get('search', ''));
        if ($search !== '') {
            $query->where(function (Builder $q) use ($search) {
                $q->where('users.full_name', 'like', "%{$search}%")
                    ->orWhere('users.email', 'like', "%{$search}%")
                    ->orWhere('users.phone', 'like', "%{$search}%");
            });
        }

        $status = (string) $request->get('status', '');
        if ($status === 'active') {
            $query->where('users.is_active', true);
        } elseif ($status === 'inactive' || $status === 'blocked') {
            $query->where('users.is_active', false);
        }

        $segment = (string) $request->get('segment', '');
        $this->applySegmentFilter($query, $segment);

        $customers = $query
            ->orderBy('users.created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $customers->getCollection()->transform(fn($customer) => $this->decorateCustomer($customer));

        $statsData = $this->baseCustomersQuery()->get()->map(fn($customer) => $this->decorateCustomer($customer));

        $stats = [
            'total' => $statsData->count(),
            'new' => $statsData->where('segment_key', 'new')->count(),
            'vip' => $statsData->where('segment_key', 'vip')->count(),
            'inactive' => $statsData->where('segment_key', 'inactive')->count(),
            'segments' => [
                'vip' => $statsData->where('segment_key', 'vip')->count(),
                'regular' => $statsData->where('segment_key', 'regular')->count(),
                'new' => $statsData->where('segment_key', 'new')->count(),
                'loyal' => $statsData->where('segment_key', 'loyal')->count(),
                'inactive' => $statsData->where('segment_key', 'inactive')->count(),
            ],
        ];

        $selectedCustomer = null;
        $selectedCustomerOrders = collect();
        if ($showCustomerId) {
            $selectedCustomer = $this->baseCustomersQuery()
                ->where('users.id', $showCustomerId)
                ->first();

            if ($selectedCustomer) {
                $selectedCustomer = $this->decorateCustomer($selectedCustomer);
                $selectedCustomerOrders = Order::query()
                    ->where('user_id', $showCustomerId)
                    ->latest('created_at')
                    ->take(10)
                    ->get();
            }
        }

        return view('admin.customers', [
            'customers' => $customers,
            'stats' => $stats,
            'selectedCustomer' => $selectedCustomer,
            'selectedCustomerOrders' => $selectedCustomerOrders,
        ]);
    }

    private function baseCustomersQuery(): Builder
    {
        $customerRoleId = $this->getCustomerRoleId();

        $orderStats = Order::query()
            ->selectRaw('user_id, COUNT(*) as total_orders, COALESCE(SUM(total_amount_cents), 0) as total_spent, MAX(created_at) as last_order_at')
            ->groupBy('user_id');

        $query = User::query()
            ->with('addresses')
            ->leftJoinSub($orderStats, 'order_stats', function ($join) {
                $join->on('users.id', '=', 'order_stats.user_id');
            })
            ->select('users.*')
            ->selectRaw('COALESCE(order_stats.total_orders, 0) as total_orders')
            ->selectRaw('COALESCE(order_stats.total_spent, 0) as total_spent')
            ->selectRaw('order_stats.last_order_at as last_order_at');

        if ($customerRoleId) {
            $query->where('users.role_id', $customerRoleId);
        }

        if (Schema::hasColumn('users', 'deleted_at')) {
            $query->whereNull('users.deleted_at');
        }

        return $query;
    }

    private function applySegmentFilter(Builder $query, string $segment): void
    {
        $startOfMonth = now()->startOfMonth();
        $inactiveCutoff = now()->subDays(90);

        if ($segment === 'vip') {
            $query->where('users.is_active', true)
                ->where('users.created_at', '<', $startOfMonth)
                ->where(function (Builder $q) {
                    $q->where('order_stats.total_spent', '>=', 5000000)
                        ->orWhere('order_stats.total_orders', '>=', 10);
                });

            return;
        }

        if ($segment === 'new') {
            $query->where('users.is_active', true)
                ->where('users.created_at', '>=', $startOfMonth);

            return;
        }

        if ($segment === 'loyal') {
            $query->where('users.is_active', true)
                ->where('users.created_at', '<', $startOfMonth)
                ->whereBetween('order_stats.total_orders', [5, 9]);

            return;
        }

        if ($segment === 'inactive') {
            $query->where(function (Builder $q) use ($inactiveCutoff, $startOfMonth) {
                $q->where('users.is_active', false)
                    ->orWhere(function (Builder $active) use ($inactiveCutoff, $startOfMonth) {
                        $active->where('users.is_active', true)
                            ->where('users.created_at', '<', $startOfMonth)
                            ->whereRaw('COALESCE(order_stats.total_orders, 0) < 5')
                            ->whereRaw('COALESCE(order_stats.total_spent, 0) < 5000000')
                            ->where(function (Builder $lastOrder) use ($inactiveCutoff) {
                                $lastOrder->whereNull('order_stats.last_order_at')
                                    ->orWhere('order_stats.last_order_at', '<', $inactiveCutoff);
                            });
                    });
            });

            return;
        }

        if ($segment === 'regular') {
            $query->where('users.is_active', true)
                ->where('users.created_at', '<', $startOfMonth)
                ->whereRaw('COALESCE(order_stats.total_orders, 0) < 5')
                ->whereRaw('COALESCE(order_stats.total_spent, 0) < 5000000')
                ->whereNotNull('order_stats.last_order_at')
                ->where('order_stats.last_order_at', '>=', $inactiveCutoff);
        }
    }

    private function decorateCustomer(User $customer): User
    {
        $totalOrders = (int) ($customer->total_orders ?? 0);
        $totalSpent = (int) ($customer->total_spent ?? 0);

        $segmentKey = $this->resolveSegment($customer);
        $segmentMap = [
            'vip' => ['text' => 'VIP', 'class' => 'segment-vip-badge'],
            'regular' => ['text' => 'Thường xuyên', 'class' => 'segment-regular-badge'],
            'new' => ['text' => 'Mới', 'class' => 'segment-new-badge'],
            'loyal' => ['text' => 'Trung thành', 'class' => 'segment-loyal-badge'],
            'inactive' => ['text' => 'Không hoạt động', 'class' => 'segment-inactive-badge'],
        ];

        $statusKey = $customer->is_active ? 'active' : 'inactive';
        $statusMap = [
            'active' => ['text' => 'Hoạt động', 'class' => 'status-active'],
            'inactive' => ['text' => 'Không hoạt động', 'class' => 'status-inactive'],
            'blocked' => ['text' => 'Đã chặn', 'class' => 'status-blocked'],
        ];

        $customer->segment_key = $segmentKey;
        $customer->segment_text = $segmentMap[$segmentKey]['text'];
        $customer->segment_class = $segmentMap[$segmentKey]['class'];

        $customer->status_key = $statusKey;
        $customer->status_text = $statusMap[$statusKey]['text'];
        $customer->status_class = $statusMap[$statusKey]['class'];

        $customer->total_orders = $totalOrders;
        $customer->total_spent = $totalSpent;
        $customer->avg_order = $totalOrders > 0 ? (int) round($totalSpent / $totalOrders) : 0;

        $customer->avatar = $this->initials($customer->full_name);
        $customer->customer_code = 'KH-' . str_pad((string) $customer->id, 6, '0', STR_PAD_LEFT);

        $createdAt = $customer->created_at ? Carbon::parse($customer->created_at) : null;
        $customer->join_date = $createdAt ? $createdAt->format('d/m/Y') : '-';
        $customer->days_since_join = $createdAt ? $createdAt->diffInDays(now()) : 0;

        $address = optional($customer->addresses->first())->address_detail;
        $customer->display_address = $address ?: 'Chưa có địa chỉ';

        $lastOrderAt = $customer->last_order_at ? Carbon::parse($customer->last_order_at) : null;
        $customer->last_order_text = $lastOrderAt ? $lastOrderAt->format('d/m/Y') : '-';

        return $customer;
    }

    private function resolveSegment(User $customer): string
    {
        $totalOrders = (int) ($customer->total_orders ?? 0);
        $totalSpent = (int) ($customer->total_spent ?? 0);

        if (! $customer->is_active) {
            return 'inactive';
        }

        $createdAt = $customer->created_at ? Carbon::parse($customer->created_at) : null;
        if ($createdAt && $createdAt->gte(now()->startOfMonth())) {
            return 'new';
        }

        if ($totalSpent >= 5000000 || $totalOrders >= 10) {
            return 'vip';
        }

        if ($totalOrders >= 5) {
            return 'loyal';
        }

        $lastOrderAt = $customer->last_order_at ? Carbon::parse($customer->last_order_at) : null;
        if (! $lastOrderAt || $lastOrderAt->lt(now()->subDays(90))) {
            return 'inactive';
        }

        return 'regular';
    }

    private function getCustomerRoleId(): ?int
    {
        return Role::query()->where('name', 'customer')->value('id');
    }

    private function initials(string $name): string
    {
        $parts = preg_split('/\s+/', trim($name)) ?: [];
        $letters = collect($parts)
            ->filter()
            ->map(fn($part) => mb_substr($part, 0, 1))
            ->take(2)
            ->implode('');

        return mb_strtoupper($letters ?: 'KH');
    }

    private function savePrimaryAddress(User $customer, ?string $address): void
    {
        if (! $address) {
            return;
        }

        $primary = $customer->addresses()->first();
        if ($primary) {
            $primary->update([
                'recipient_name' => $customer->full_name,
                'recipient_phone' => $customer->phone ?? '',
                'address_detail' => $address,
                'ward' => $primary->ward ?: '-',
                'district' => $primary->district ?: '-',
                'city' => $primary->city ?: '-',
                'type' => $primary->type ?: 'home',
                'is_default' => true,
            ]);

            return;
        }

        $customer->addresses()->create([
            'recipient_name' => $customer->full_name,
            'recipient_phone' => $customer->phone ?? '',
            'address_detail' => $address,
            'ward' => '-',
            'district' => '-',
            'city' => '-',
            'type' => 'home',
            'is_default' => true,
        ]);
    }
}
