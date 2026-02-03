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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id(); // id khóa chính

            // Người đánh giá
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade'); // xóa user thì xóa luôn đánh giá

            // Sản phẩm được đánh giá
            $table->foreignId('product_id')
                ->constrained('products')
                ->onDelete('cascade'); // xóa sản phẩm thì xóa đánh giá

            // Liên kết với đơn hàng (để đảm bảo chỉ khách đã mua mới được đánh giá)
            $table->foreignId('order_id')
                ->constrained('orders')
                ->onDelete('cascade');

            // Số sao đánh giá: từ 1 đến 5
            $table->unsignedTinyInteger('rating')
                ->check('rating >= 1 AND rating <= 5');

            // Nội dung bình luận
            $table->text('comment')->nullable();

            // Trạng thái duyệt: true = hiển thị công khai, false = đang chờ duyệt
            $table->boolean('is_approved')->default(false);

            // Thời gian tạo đánh giá
            $table->timestamp('created_at')->useCurrent();

            // Không dùng updated_at vì đánh giá thường không chỉnh sửa
            // Nếu cần thì thêm $table->timestamps();
        });

        // Đảm bảo một user chỉ đánh giá một sản phẩm trong một đơn hàng duy nhất 1 lần
        Schema::table('reviews', function (Blueprint $table) {
            $table->unique(['user_id', 'product_id', 'order_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};