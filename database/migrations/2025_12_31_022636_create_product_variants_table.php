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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id(); // id khóa chính (bigint unsigned auto_increment)

            // Khóa ngoại product_id trỏ đến bảng products
            $table->foreignId('product_id')
                ->constrained('products')     // ràng buộc khóa ngoại
                ->onDelete('cascade');        // nếu xóa sản phẩm thì xóa luôn các biến thể

            // Mã kho hàng duy nhất (SKU) - bắt buộc unique
            $table->string('sku')->unique();

            // Tên biến thể (ví dụ: "Đỏ - Size M", "Phô mai thêm")
            $table->string('name');

            // Điều chỉnh giá so với giá gốc của sản phẩm (có thể âm hoặc dương)
            // Ví dụ: +10.000 hoặc -5.000
            $table->decimal('price_adjustment', 15, 2)->default(0);

            // Số lượng tồn kho của biến thể này
            $table->unsignedInteger('stock_quantity')->default(0);

            $table->timestamps(); // created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
