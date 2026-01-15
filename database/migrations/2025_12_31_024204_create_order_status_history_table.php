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
        Schema::create('order_status_history', function (Blueprint $table) {
            $table->id(); // id khóa chính

            // Đơn hàng liên quan
            $table->foreignId('order_id')
                ->constrained('orders')
                ->onDelete('cascade'); // xóa đơn hàng thì xóa luôn lịch sử trạng thái

            // Trạng thái đơn hàng tại thời điểm này
            // Ví dụ: pending, confirmed, preparing, shipping, delivered, cancelled, refunded
            $table->string('status');

            // Ghi chú từ nhân viên khi thay đổi trạng thái (ví dụ: "Đã liên hệ khách", "Giao thất bại")
            $table->text('note')->nullable();

            // Thời điểm chính xác chuyển sang trạng thái này
            $table->timestamp('timestamp')->useCurrent();

            $table->timestamps(); // created_at và updated_at (tùy chọn, có thể bỏ nếu không cần)

            // Index để truy vấn lịch sử theo đơn hàng nhanh hơn
            $table->index('order_id');
            $table->index('timestamp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_status_history');
    }
};
