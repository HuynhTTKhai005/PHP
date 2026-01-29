<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
     
    public function profile(Request $request): View
    {
        $user = $request->user()->load(['addresses' => function ($q) {
            $q->where('is_default', true); // Chỉ lấy địa chỉ mặc định
        }]);

        return view('frontend.profile', compact('user'));
    }

    
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

         $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone'     => ['nullable', 'string', 'max:20'],
            'avatar'    => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Cập nhật thông tin cơ bản
        $user->full_name = $request->full_name;
        $user->phone = $request->phone;

        // Xử lý upload ảnh đại diện (cột avatar_url trong DB)
        if ($request->hasFile('avatar')) {
            // Xóa ảnh cũ nếu có
            if ($user->avatar_url) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $user->avatar_url));
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar_url = '/storage/' . $path;
        }

        $user->save();

        return redirect()->route('profile')->with('status', 'Thông tin đã được cập nhật thành công!');
    }

    /**
     * Thay đổi mật khẩu (Xử lý trường password_hash trong sơ đồ)
     */
    public function changePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->update([
            'password_hash' => Hash::make($request->password),
        ]);

        return back()->with('status', 'Mật khẩu đã được thay đổi!');
    }

    /**
     * Xóa tài khoản (Nếu cần thiết)
     */
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