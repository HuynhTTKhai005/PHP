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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // id khóa chính

            // Người nhận thông báo
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade'); // xóa user thì xóa luôn thông báo của họ

            // Tiêu đề thông báo
            $table->string('title');

            // Nội dung chi tiết thông báo
            $table->text('message');

            // Loại thông báo (order_update, promotion, system_alert, password_reset, etc.)
            $table->string('type');

            // Trạng thái đã đọc hay chưa
            $table->boolean('is_read')->default(false);

            // Thời gian tạo thông báo
            $table->timestamp('created_at')->useCurrent();

            // Không cần updated_at vì thông báo thường không sửa nội dung
            // Nếu cần thì thêm $table->timestamps();
        });

        // Tối ưu tìm kiếm theo user + trạng thái đọc + thời gian
        Schema::table('notifications', function (Blueprint $table) {
            $table->index(['user_id', 'is_read', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
