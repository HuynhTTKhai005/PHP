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
        Schema::create('product_addons', function (Blueprint $table) {
            $table->id(); // id khóa chính

            // Sản phẩm chính (sản phẩm mà có thể thêm topping)
            $table->foreignId('product_id')
                ->constrained('products')
                ->onDelete('cascade'); // xóa sản phẩm chính thì xóa luôn các addon liên kết

            // Sản phẩm được dùng làm addon (topping)
            $table->foreignId('addon_product_id')
                ->constrained('products')
                ->onDelete('cascade'); // xóa sản phẩm addon thì xóa khỏi danh sách

            $table->timestamps(); // created_at và updated_at (tùy chọn)

            // Ngăn trùng lặp: một sản phẩm không thể thêm cùng một addon 2 lần
            $table->unique(['product_id', 'addon_product_id']);

            // Index để truy vấn nhanh các addon của một sản phẩm
            $table->index('product_id');
            $table->index('addon_product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_addons');
    }
};
