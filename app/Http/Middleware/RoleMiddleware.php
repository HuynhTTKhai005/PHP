<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        /** @var User $user */
        $user = Auth::user();
        $allowedRoleIds = $this->normalizeRoleIds($roles);

        if (empty($allowedRoleIds) || ! in_array((int) $user->role_id, $allowedRoleIds, true)) {
            if ((int) $user->role_id === User::ROLE_CUSTOMER) {
                return redirect()->route('home');
            }

            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        return $next($request);
    }

    private function normalizeRoleIds(array $roles): array
    {
        $roleMap = [
            'admin' => User::ROLE_ADMIN,
            'staff' => User::ROLE_STAFF,
            'employee' => User::ROLE_STAFF,
            'customer' => User::ROLE_CUSTOMER,
            'guest' => User::ROLE_CUSTOMER,
        ];

        $allowedRoleIds = [];

        foreach ($roles as $role) {
            if (is_numeric($role)) {
                $allowedRoleIds[] = (int) $role;

                continue;
            }

            $key = strtolower(trim((string) $role));
            if (array_key_exists($key, $roleMap)) {
                $allowedRoleIds[] = $roleMap[$key];
            }
        }

        return array_values(array_unique($allowedRoleIds));
    }
}
