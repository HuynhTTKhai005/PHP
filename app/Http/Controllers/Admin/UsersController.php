<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UsersController extends Controller
{
    private const MANAGEABLE_ROLE_IDS = [User::ROLE_ADMIN, User::ROLE_STAFF];

    public function createUser(): View
    {
        return view('admin.users_create');
    }

    public function index(Request $request): View
    {
        $usersQuery = User::query()->whereIn('role_id', self::MANAGEABLE_ROLE_IDS);

        if ($request->filled('search')) {
            $search = trim((string) $request->search);
            $usersQuery->where(function ($query) use ($search): void {
                $query->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role_id')) {
            $usersQuery->where('role_id', (int) $request->role_id);
        }

        if ($request->filled('status')) {
            $usersQuery->where('is_active', $request->status === 'active');
        }

        $users = $usersQuery->latest()->paginate(12)->withQueryString();
        $users->getCollection()->transform(function (User $user): User {
            $user->role_label = $this->mapRoleLabel((int) $user->role_id);
            $user->role_badge = $this->mapRoleBadge((int) $user->role_id);
            $user->status_label = $user->is_active ? 'Hoạt động' : 'Đã khóa';
            $user->status_badge = $user->is_active ? 'status-completed' : 'status-cancelled';

            return $user;
        });

        $stats = [
            'total' => User::whereIn('role_id', self::MANAGEABLE_ROLE_IDS)->count(),
            'admin' => User::where('role_id', User::ROLE_ADMIN)->count(),
            'staff' => User::where('role_id', User::ROLE_STAFF)->count(),
            'active' => User::whereIn('role_id', self::MANAGEABLE_ROLE_IDS)->where('is_active', true)->count(),
        ];

        return view('admin.users', compact('users', 'stats'));
    }

    public function storeUser(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role_id' => ['required', 'integer', 'in:'.User::ROLE_ADMIN.','.User::ROLE_STAFF, 'exists:roles,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $user = User::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password_hash' => Hash::make($validated['password']),
            'role_id' => (int) $validated['role_id'],
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ]);

        $this->logAudit('create', 'users', $user->id, null, $user->toArray(), $request);

        return redirect()->route('admin.users')->with('success', 'Thêm người dùng thành công.');
    }

    public function updateUserRole(Request $request, User $user): RedirectResponse
    {
        if (! $this->isManageableRole((int) $user->role_id)) {
            return redirect()->route('admin.users')->with('error', 'Trang này chỉ quản lý role Admin và Nhân viên.');
        }

        $validated = $request->validate([
            'role_id' => ['required', 'integer', 'in:'.User::ROLE_ADMIN.','.User::ROLE_STAFF, 'exists:roles,id'],
        ]);

        $newRoleId = (int) $validated['role_id'];

        if ((int) Auth::id() === (int) $user->id && $newRoleId !== User::ROLE_ADMIN) {
            return redirect()->route('admin.users')->with('error', 'Bạn không thể hạ quyền tài khoản đang đăng nhập.');
        }

        if ((int) $user->role_id === $newRoleId) {
            return redirect()->route('admin.users')->with('success', 'Không có thay đổi quyền.');
        }

        $oldValues = ['role_id' => $user->role_id];
        $user->update(['role_id' => $newRoleId]);
        $this->logAudit('update', 'users', $user->id, $oldValues, ['role_id' => $newRoleId], $request);

        return redirect()->route('admin.users')->with('success', 'Cập nhật quyền thành công.');
    }

    public function updateUserStatus(Request $request, User $user): RedirectResponse
    {
        if (! $this->isManageableRole((int) $user->role_id)) {
            return redirect()->route('admin.users')->with('error', 'Trang này chỉ quản lý role Admin và Nhân viên.');
        }

        $validated = $request->validate([
            'is_active' => ['required', 'boolean'],
        ]);

        $newStatus = (bool) $validated['is_active'];

        if ((int) Auth::id() === (int) $user->id && ! $newStatus) {
            return redirect()->route('admin.users')->with('error', 'Bạn không thể tự khóa tài khoản của mình.');
        }

        if ((bool) $user->is_active === $newStatus) {
            return redirect()->route('admin.users')->with('success', 'Không có thay đổi trạng thái.');
        }

        $oldValues = ['is_active' => (bool) $user->is_active];
        $user->update(['is_active' => $newStatus]);
        $this->logAudit('update', 'users', $user->id, $oldValues, ['is_active' => $newStatus], $request);

        return redirect()->route('admin.users')->with('success', 'Cập nhật trạng thái thành công.');
    }

    public function destroyUser(Request $request, User $user): RedirectResponse
    {
        if (! $this->isManageableRole((int) $user->role_id)) {
            return redirect()->route('admin.users')->with('error', 'Trang này chỉ quản lý role Admin và Nhân viên.');
        }

        if ((int) Auth::id() === (int) $user->id) {
            return redirect()->route('admin.users')->with('error', 'Bạn không thể tự xóa tài khoản đang đăng nhập.');
        }

        if ((int) $user->role_id === User::ROLE_ADMIN && User::where('role_id', User::ROLE_ADMIN)->count() <= 1) {
            return redirect()->route('admin.users')->with('error', 'Không thể xóa admin cuối cùng của hệ thống.');
        }

        $oldValues = $user->toArray();
        $userId = $user->id;
        $user->delete();
        $this->logAudit('delete', 'users', $userId, $oldValues, null, $request);

        return redirect()->route('admin.users')->with('success', 'Xóa tài khoản thành công.');
    }

    public function createRole(): RedirectResponse
    {
        return redirect()->route('admin.users');
    }

    public function storeRole(Request $request): RedirectResponse
    {
        return redirect()->route('admin.users');
    }

    public function editRole(Role $role): RedirectResponse
    {
        return redirect()->route('admin.users');
    }

    public function updateRole(Request $request, Role $role): RedirectResponse
    {
        return redirect()->route('admin.users');
    }

    public function destroyRole(Request $request, Role $role): RedirectResponse
    {
        return redirect()->route('admin.users');
    }

    private function isManageableRole(int $roleId): bool
    {
        return in_array($roleId, self::MANAGEABLE_ROLE_IDS, true);
    }

    private function mapRoleLabel(int $roleId): string
    {
        return match ($roleId) {
            User::ROLE_ADMIN => 'Admin',
            User::ROLE_STAFF => 'Nhân viên',
            default => 'Không xác định',
        };
    }

    private function mapRoleBadge(int $roleId): string
    {
        return match ($roleId) {
            User::ROLE_ADMIN => 'status-completed',
            User::ROLE_STAFF => 'status-processing',
            default => 'status-cancelled',
        };
    }

    private function logAudit(
        string $action,
        string $table,
        ?int $recordId,
        ?array $oldValues,
        ?array $newValues,
        Request $request
    ): void {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'table_name' => $table,
            'record_id' => $recordId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => $request->ip(),
            'timestamp' => now(),
        ]);
    }
}