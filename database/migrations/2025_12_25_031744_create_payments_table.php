<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained('orders')
                ->onDelete('cascade'); // Xóa đơn hàng thì xóa thanh toán

            $table->string('payment_method');
 // cash, bank_transfer, vnpay, momo, zalo_pay, etc.

            $table->integer('amount_cents')->unsigned(); // Số tiền thanh toán (cents hoặc đồng tùy bạn)

            $table->string('transaction_code')->nullable(); // Mã giao dịch từ cổng thanh toán (nếu có)

            $table->enum('status', ['pending', 'success', 'failed', 'refunded'])
                ->default('pending');

            $table->timestamp('payment_date')->nullable(); // Thời gian thanh toán thành công

            $table->timestamps();

            // Index để tìm kiếm nhanh theo order_id và status
            $table->index(['order_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
