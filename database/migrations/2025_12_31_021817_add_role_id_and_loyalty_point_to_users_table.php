<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Thêm role_id (khóa ngoại trỏ về bảng roles)
            $table->foreignId('role_id')
                ->nullable() // cho phép null nếu có user cũ chưa có role
                ->constrained('roles') // ràng buộc khóa ngoại
                ->onDelete('set null') // nếu xóa role thì role_id = null
                ->after('last_login_at'); // đặt sau cột last_login_at

            // Thêm điểm tích lũy khách hàng
            $table->unsignedInteger('loyalty_point')
                ->default(0)
                ->after('role_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn(['role_id', 'loyalty_point']);
        });
    }
};