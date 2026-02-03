<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy role từ database (đảm bảo RoleSeeder đã chạy trước)
        $adminRole = Role::where('name', 'admin')->first();
        $staffRole = Role::where('name', 'staff')->first();
        $customerRole = Role::where('name', 'customer')->first();

        // Nếu role chưa tồn tại → báo lỗi để bạn chạy RoleSeeder trước
        if (!$adminRole || !$staffRole || !$customerRole) {
            $this->command->error('Vui lòng chạy RoleSeeder trước khi chạy UserSeeder!');
            return;
        }



        // === TÀI KHOẢN STAFF (Nhân viên) ===
        User::updateOrCreate(
            ['email' => 'staff1@example.com'],
            [
                'full_name'     => 'Nhân viên 1',
                'email'         => 'staff1@example.com',
                'phone'         => '0902345678',
                'password_hash' => Hash::make('123456'),
                'is_active'     => true,
                'role_id'       => $staffRole->id,
                'loyalty_point' => 0,
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff2@example.com'],
            [
                'full_name'     => 'Nhân viên 2',
                'email'         => 'staff2@example.com',
                'phone'         => '0903456789',
                'password_hash' => Hash::make('123456'),
                'is_active'     => true,
                'role_id'       => $staffRole->id,
                'loyalty_point' => 0,
            ]
        );

        // === TÀI KHOẢN CUSTOMER (Khách hàng) ===
        $customers = [
            ['Nguyễn Văn A', 'vana@example.com', '0911111111'],
            ['Trần Thị B', 'tranb@example.com', '0912222222'],
            ['Lê Văn C', 'levanc@example.com', '0913333333'],
            ['Phạm Thị D', 'phamd@example.com', '0914444444'],
            ['Hoàng Văn E', 'hoange@example.com', '0915555555'],
        ];

        foreach ($customers as $index => $cust) {
            User::updateOrCreate(
                ['email' => $cust[1]],
                [
                    'full_name'     => $cust[0],
                    'email'         => $cust[1],
                    'phone'         => $cust[2],
                    'password_hash' => Hash::make('123456'),
                    'is_active'     => true,
                    'role_id'       => $customerRole->id,
                    'loyalty_point' => 100 * ($index + 1),
                ]
            );
        } // === TÀI KHOẢN ADMIN ===
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'full_name'     => 'Quản trị viên',
                'email'         => 'admin@example.com',
                'phone'         => '0901112223',
                'password_hash' => Hash::make('123456'),
                'is_active'     => true,
                'role_id'       => $adminRole->id,
                'loyalty_point' => 0,
            ]
        );

        $this->command->info('UserSeeder hoàn thành! Tạo 1 admin, 2 staff, 5 customer.');
    }
}
