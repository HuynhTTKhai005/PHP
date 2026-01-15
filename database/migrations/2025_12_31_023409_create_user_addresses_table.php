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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id(); // id khóa chính (bigint unsigned auto_increment)

            // Khóa ngoại user_id trỏ đến bảng users
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade'); // nếu xóa user thì xóa luôn các địa chỉ

            // Tên người nhận hàng
            $table->string('recipient_name');

            // Số điện thoại người nhận
            $table->string('recipient_phone');

            // Loại địa chỉ (ví dụ: home, office, other)
            $table->string('type')->default('home');
            // có thể dùng enum nếu muốn giới hạn: $table->enum('type', ['home', 'office', 'other'])->default('home');

            // Thông tin địa chỉ hành chính Việt Nam
            $table->string('city');       // Tỉnh/Thành phố
            $table->string('district');   // Quận/Huyện
            $table->string('ward');       // Phường/Xã

            // Chi tiết địa chỉ: số nhà, tên đường, thôn/xóm...
            $table->string('address_detail');

            // Đánh dấu đây có phải là địa chỉ mặc định không
            $table->boolean('is_default')->default(false);

            $table->timestamps(); // created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
