<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!$user->role) {
            abort(403, 'User does not have any role assigned.');
        }

        if (!in_array($user->role->name, $roles)) {
            if ($user->role->name === 'customer') {
                return redirect()->route('home');
            }

            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        return $next($request);
    }
}
