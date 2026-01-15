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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id(); // id khóa chính

            // Người thực hiện hành động (có thể null nếu là hệ thống)
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            // Hành động thực hiện: create, update, delete (có thể mở rộng thêm: login, logout...)
            $table->enum('action', ['create', 'update', 'delete', 'login', 'logout'])
                ->index();

            // Tên bảng bị tác động (users, products, orders, roles...)
            $table->string('table_name');

            // ID của bản ghi bị tác động (ví dụ: id sản phẩm bị sửa)
            $table->unsignedBigInteger('record_id')->nullable();

            // Dữ liệu cũ (trước khi thay đổi) - lưu dưới dạng JSON
            $table->json('old_values')->nullable();

            // Dữ liệu mới (sau khi thay đổi) - lưu dưới dạng JSON
            $table->json('new_values')->nullable();

            // Địa chỉ IP của người thực hiện
            $table->string('ip_address')->nullable();

            // Thời điểm thực hiện hành động
            $table->timestamp('timestamp')->useCurrent();

            $table->timestamps(); // created_at, updated_at (tùy chọn)

            // Index tối ưu cho việc tra cứu
            $table->index(['table_name', 'record_id']);
            $table->index('timestamp');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};