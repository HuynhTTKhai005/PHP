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
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id(); // id khóa chính (bigint unsigned auto_increment)

            // Khóa ngoại product_id trỏ đến bảng products
            $table->foreignId('product_id')
                ->constrained('products')
                ->onDelete('cascade');

            // Khóa ngoại variant_id trỏ đến bảng product_variants (có thể null nếu không dùng biến thể)
            $table->foreignId('variant_id')
                ->nullable()
                ->constrained('product_variants')
                ->onDelete('cascade');

            // Loại giao dịch: 'in' (nhập kho) hoặc 'out' (xuất kho)
            $table->enum('type', ['in', 'out']);

            // Số lượng thay đổi (dương cho nhập, âm cho xuất)
            $table->integer('change_quantity');

            // Số lượng tồn kho hiện tại SAU giao dịch
            $table->unsignedInteger('current_stock');

            // Lý do giao dịch (nhập từ nhà cung cấp, xuất bán, trả hàng, hỏng hóc...)
            $table->string('reason')->nullable();

            // Ghi chú chi tiết
            $table->text('note')->nullable();

            // Thời điểm thực hiện giao dịch
            $table->timestamp('performed_at')->useCurrent(); // tự động lấy thời gian hiện tại

            $table->timestamps(); // created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
