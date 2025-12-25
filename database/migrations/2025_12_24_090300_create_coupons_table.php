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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id(); // khóa chính

            $table->string('code')->unique(); // mã giảm giá, duy nhất
            $table->text('description')->nullable(); // mô tả chương trình

            $table->enum('discount_type', ['fixed', 'percent']); // loại giảm: cố định hoặc %
            $table->bigInteger('discount_value'); // giá trị giảm (cents nếu fixed, % nếu percent)

            $table->bigInteger('min_order_total_amount_cents')->default(0); // đơn tối thiểu (cents)
            $table->bigInteger('max_discount_amount_cents')->nullable(); // giảm tối đa (cents, dùng cho %)

            $table->integer('usage_limit')->nullable(); // tổng số lần dùng tối đa
            $table->integer('used_count')->default(0); // số lần đã dùng

            $table->boolean('is_active')->default(true); // đang hoạt động?

            $table->timestamp('starts_at')->nullable(); // ngày bắt đầu
            $table->timestamp('expires_at')->nullable(); // ngày hết hạn

            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
