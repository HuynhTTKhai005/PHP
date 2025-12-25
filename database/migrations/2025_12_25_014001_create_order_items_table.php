<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                ->constrained('orders')
                ->onDelete('cascade'); // Xóa đơn hàng thì xóa luôn chi tiết
            $table->foreignId('product_id')
                ->constrained('products')
                ->onDelete('restrict'); // Không cho xóa sản phẩm nếu đang có trong đơn
            $table->integer('quantity')->unsigned();
            $table->integer('unit_price_cents')->unsigned(); // Giá mỗi món tại thời điểm đặt (cents)
            $table->integer('total_cents')->unsigned();      // Tổng tiền món này = quantity × unit_price_cents
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};