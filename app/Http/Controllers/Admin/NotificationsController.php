<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Notification;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationsController extends Controller
{
    public function index(Request $request): View
    {
        return $this->renderIndex($request);
    }

    public function show(Request $request, Notification $notification): View
    {
        return $this->renderIndex($request, $notification->id);
    }

    public function create(): View
    {
        $roles = Role::orderBy('name')->get();
        $users = User::orderBy('full_name')->limit(200)->get();

        return view('admin.notification_create', compact('roles', 'users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'recipient_mode' => 'required|in:all,role,user',
            'role_id' => 'nullable|integer|exists:roles,id',
            'user_id' => 'nullable|integer|exists:users,id',
            'type' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $recipientQuery = User::query();
        if ($validated['recipient_mode'] === 'role') {
            $recipientQuery->where('role_id', $validated['role_id']);
        } elseif ($validated['recipient_mode'] === 'user') {
            $recipientQuery->where('id', $validated['user_id']);
        }

        $recipientIds = $recipientQuery->pluck('id');

        foreach ($recipientIds as $userId) {
            Notification::create([
                'user_id' => $userId,
                'title' => $validated['title'],
                'message' => $validated['message'],
                'type' => $validated['type'],
                'is_read' => false,
            ]);
        }

        $this->logAudit('create', 'notifications', null, null, [
            'title' => $validated['title'],
            'type' => $validated['type'],
            'recipient_mode' => $validated['recipient_mode'],
            'recipient_count' => $recipientIds->count(),
        ], $request);

        return redirect()->route('admin.notifications')->with('success', 'Gui thong bao thành công.');
    }

    public function markRead(Request $request, Notification $notification): RedirectResponse
    {
        $oldValues = $notification->toArray();

        $notification->update(['is_read' => true]);

        $this->logAudit('update', 'notifications', $notification->id, $oldValues, $notification->toArray(), $request);

        return back()->with('success', 'Da danh dau da doc.');
    }

    public function destroy(Request $request, Notification $notification): RedirectResponse
    {
        $oldValues = $notification->toArray();
        $id = $notification->id;
        $notification->delete();

        $this->logAudit('delete', 'notifications', $id, $oldValues, null, $request);

        return redirect()->route('admin.notifications')->with('success', 'Xóa thong bao thành công.');
    }

    private function renderIndex(Request $request, ?int $showId = null): View
    {
        $query = Notification::query()->with('user:id,full_name,email');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('is_read')) {
            $query->where('is_read', (bool) ((int) $request->is_read));
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        if ($request->filled('search')) {
            $search = trim((string) $request->search);
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('email', 'like', "%{$search}%")
                            ->orWhere('full_name', 'like', "%{$search}%");
                    });
            });
        }

        $notifications = $query->latest('created_at')->paginate(20)->withQueryString();

        $stats = [
            'total' => Notification::count(),
            'read' => Notification::where('is_read', true)->count(),
            'unread' => Notification::where('is_read', false)->count(),
            'today' => Notification::whereDate('created_at', today())->count(),
        ];

        $selectedNotification = null;
        if ($showId) {
            $selectedNotification = Notification::with('user')->find($showId);
        }

        return view('admin.notifications', compact('notifications', 'stats', 'selectedNotification'));
    }

    private function logAudit(string $action, string $table, ?int $recordId, ?array $oldValues, ?array $newValues, Request $request): void
    {
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
