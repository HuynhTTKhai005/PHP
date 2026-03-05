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
        Schema::create('order_item_addons', function (Blueprint $table) {
            $table->id(); // id khóa chính

            // Liên kết đến món trong đơn hàng (order_items)
            $table->foreignId('order_item_id')
                ->constrained('order_items')
                ->onDelete('cascade'); // xóa món thì xóa luôn addon

            // Sản phẩm được dùng làm addon
            $table->foreignId('addon_product_id')
                ->constrained('products')
                ->onDelete('restrict'); // không cho xóa sản phẩm nếu đang dùng trong đơn cũ

            // Tên addon tại thời điểm đặt hàng (để hiển thị nhanh, tránh join)
            $table->string('addon_name');

            // Số lượng addon khách chọn
            $table->unsignedSmallInteger('quantity')->default(1);

            // Giá mỗi addon theo cents (ví dụ: 10000 = 100.00₫)
            $table->unsignedInteger('unit_price_cents')->default(0);

            // Tổng tiền addon theo cents (quantity * unit_price_cents)
            $table->unsignedInteger('total_cents')->default(0);

            $table->timestamps(); // created_at và updated_at

            // Index tối ưu truy vấn theo order_item
            $table->index('order_item_id');
            $table->index('addon_product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item_addons');
    }
};
