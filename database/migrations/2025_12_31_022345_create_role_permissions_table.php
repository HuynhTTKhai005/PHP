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
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id(); // id khóa chính (tùy chọn, nhưng tốt để có)

            // Khóa ngoại role_id trỏ đến bảng roles
            $table->foreignId('role_id')
                ->constrained('roles')     // ràng buộc khóa ngoại
                ->onDelete('cascade');     // nếu xóa role thì xóa luôn các bản ghi liên quan

            // Khóa ngoại permission_id trỏ đến bảng permissions
            $table->foreignId('permission_id')
                ->constrained('permissions')
                ->onDelete('cascade');     // nếu xóa permission thì xóa luôn bản ghi liên quan

            $table->timestamps(); // created_at và updated_at (tùy chọn)

            // Đảm bảo một role không thể gán trùng một permission
            $table->unique(['role_id', 'permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};