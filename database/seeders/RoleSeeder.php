<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name'        => 'admin',
                'description' => 'Quản trị viên - Có toàn quyền truy cập và quản lý hệ thống',
            ],
            [
                'name'        => 'staff',
                'description' => 'Nhân viên - Quản lý đơn hàng, sản phẩm, tồn kho và phục vụ khách',
            ],
            [
                'name'        => 'customer',
                'description' => 'Khách hàng - Đặt món, xem lịch sử đơn hàng và tích điểm',
            ],
        ];

        foreach ($roles as $roleData) {
            Role::updateOrCreate(
                ['name' => $roleData['name']], // Nếu role đã tồn tại thì không tạo mới
                $roleData
            );
        }
    }
}