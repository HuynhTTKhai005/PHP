<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UseraddressesSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo địa chỉ cho các tài khoản Quản trị & Nhân viên
        $staffEmails = ['admin@example.com', 'staff1@example.com', 'staff2@example.com'];
        foreach ($staffEmails as $email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                DB::table('user_addresses')->updateOrInsert(
                    ['user_id' => $user->id],
                    [
                        'recipient_name'  => $user->full_name,
                        'recipient_phone' => $user->phone,
                        'address_detail'  => '70 Tô Ký, P. Tân Chánh Hiệp',
                        'ward'            => 'Phường Tân Chánh Hiệp',
                        'district'        => 'Quận 12',
                        'city'            => 'TP. Hồ Chí Minh',
                        'type'            => 'office',
                        'is_default'      => true,
                        'created_at'      => now(),
                    ]
                );
            }
        }

        // 2. Tạo địa chỉ riêng biệt cho từng Khách hàng (Customer)
        $customers = [
            ['email' => 'vana@example.com',   'address' => '123 Lê Lợi', 'district' => 'Quận 1'],
            ['email' => 'tranb@example.com',  'address' => '456 Nguyễn Huệ', 'district' => 'Quận 1'],
            ['email' => 'levanc@example.com', 'address' => '789 CMT8', 'district' => 'Quận 3'],
            ['email' => 'phamd@example.com',  'address' => '101 Quang Trung', 'district' => 'Quận Gò Vấp'],
            ['email' => 'hoange@example.com', 'address' => '202 Võ Văn Ngân', 'district' => 'Thủ Đức'],
        ];

        foreach ($customers as $cust) {
            $user = User::where('email', $cust['email'])->first();
            if ($user) {
                DB::table('user_addresses')->updateOrInsert(
                    ['user_id' => $user->id],
                    [
                        'recipient_name'  => $user->full_name,
                        'recipient_phone' => $user->phone,
                        'address_detail'  => $cust['address'],
                        'ward'            => 'Phường ' . rand(1, 15),
                        'district'        => $cust['district'],
                        'city'            => 'TP. Hồ Chí Minh',
                        'type'            => 'home',
                        'is_default'      => true,
                        'created_at'      => now(),
                    ]
                );
            }
        }
    }
}
