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
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id(); // id khóa chính

            // Người dùng sở hữu wishlist
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade'); // xóa user thì xóa luôn wishlist

            // Sản phẩm được thêm vào yêu thích
            $table->foreignId('product_id')
                ->constrained('products')
                ->onDelete('cascade'); // xóa sản phẩm thì xóa khỏi wishlist

            // Thời gian thêm vào danh sách yêu thích
            $table->timestamp('created_at')->useCurrent();

            // Không cần updated_at vì wishlist thường không cập nhật

            // Đảm bảo một user chỉ thêm một sản phẩm vào wishlist duy nhất 1 lần
            $table->unique(['user_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
