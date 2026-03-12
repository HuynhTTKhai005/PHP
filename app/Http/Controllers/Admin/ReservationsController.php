<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReservationsController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $status = $request->string('status')->toString();
        $search = trim($request->string('search')->toString());
        $dateFrom = $request->string('date_from')->toString();
        $dateTo = $request->string('date_to')->toString();

        $query = Reservation::query()->orderByDesc('reservation_date')->orderByDesc('reservation_time');

        if ($status !== '' && in_array($status, ['pending', 'confirmed', 'cancelled', 'completed'], true)) {
            $query->where('status', $status);
        }

        if ($dateFrom !== '') {
            $query->whereDate('reservation_date', '>=', $dateFrom);
        }

        if ($dateTo !== '') {
            $query->whereDate('reservation_date', '<=', $dateTo);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search): void {
                $q->where('full_name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $reservations = $query->paginate(15)->withQueryString();
        $reservations->getCollection()->transform(function (Reservation $reservation): Reservation {
            $reservation->status_text = $this->statusText($reservation->status);
            $reservation->status_class = $this->statusClass($reservation->status);
            $reservation->can_confirm = $reservation->status === 'pending';
            $reservation->can_cancel = in_array($reservation->status, ['pending', 'confirmed'], true);

            return $reservation;
        });

        $stats = [
            'total' => Reservation::count(),
            'today' => Reservation::whereDate('reservation_date', now()->toDateString())->count(),
            'pending' => Reservation::where('status', 'pending')->count(),
            'confirmed' => Reservation::where('status', 'confirmed')->count(),
            'cancelled' => Reservation::where('status', 'cancelled')->count(),
        ];

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'stats_html' => view('admin.partials.reservations_stats', compact('stats'))->render(),
                'table_html' => view('admin.partials.reservations_table', compact('reservations'))->render(),
            ]);
        }

        return view('admin.reservations', compact('reservations', 'stats'));
    }

    public function updateStatus(Request $request, Reservation $reservation): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:confirmed,cancelled'],
        ]);

        $nextStatus = $validated['status'];

        if ($nextStatus === 'confirmed' && $reservation->status !== 'pending') {
            if ($request->expectsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Chỉ bàn đang chờ mới có thể xác nhận.'], 422);
            }

            return back()->with('error', 'Chỉ bàn đang chờ mới có thể xác nhận.');
        }

        if ($nextStatus === 'cancelled' && ! in_array($reservation->status, ['pending', 'confirmed'], true)) {
            if ($request->expectsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Chỉ bàn chờ hoặc đã xác nhận mới có thể hủy.'], 422);
            }

            return back()->with('error', 'Chỉ bàn chờ hoặc đã xác nhận mới có thể hủy.');
        }

        $reservation->update(['status' => $nextStatus]);

        $message = $nextStatus === 'confirmed' ? 'Đã xác nhận đặt bàn.' : 'Đã hủy đặt bàn.';

        if ($request->expectsJson()) {
            return response()->json(['status' => 'success', 'message' => $message]);
        }

        return back()->with('success', $message);
    }

    private function statusText(string $status): string
    {
        return match ($status) {
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'cancelled' => 'Đã hủy',
            'completed' => 'Hoàn thành',
            default => ucfirst($status),
        };
    }

    private function statusClass(string $status): string
    {
        return match ($status) {
            'pending' => 'status-pending',
            'confirmed' => 'status-processing',
            'cancelled' => 'status-cancelled',
            'completed' => 'status-completed',
            default => 'status-pending',
        };
    }
}