<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function index(): View
    {
        return view('frontend.reservation');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['required', 'date_format:H:i'],
            'people' => ['required', 'integer', 'min:1', 'max:20'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'note' => ['nullable', 'string', 'max:500'],
        ], [
            'required' => ':attribute không được để trống.',
            'date' => ':attribute không hợp lệ.',
            'after_or_equal' => ':attribute phải từ hôm nay trở đi.',
            'date_format' => ':attribute không đúng định dạng.',
            'integer' => ':attribute phải là số nguyên.',
            'min' => ':attribute tối thiểu :min.',
            'max' => ':attribute tối đa :max.',
            'email.email' => ':attribute không đúng định dạng email.',
        ], [
            'date' => 'Ngày đặt bàn',
            'time' => 'Giờ đặt bàn',
            'people' => 'Số người',
            'name' => 'Tên',
            'phone' => 'Số điện thoại',
            'email' => 'Email',
            'note' => 'Ghi chú',
        ]);

        Reservation::create([
            'full_name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'reservation_date' => $validated['date'],
            'reservation_time' => $validated['time'],
            'people_count' => (int) $validated['people'],
            'note' => $validated['note'] ?? null,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Đặt bàn thành công. Chúng tôi sẽ liên hệ xác nhận sớm nhất.');
    }
}
