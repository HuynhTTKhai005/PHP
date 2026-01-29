<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Useraddresses extends Model
{
    use HasFactory;

    /**
     * Tên bảng trong Database (đảm bảo khớp với Migration của bạn)
     */
    protected $table = 'user_addresses';

    /**
     * Các trường được phép nhập liệu/cập nhật hàng loạt
     */
    protected $fillable = [
        'user_id',
        'recipient_name',
        'recipient_phone',
        'address_detail',
        'ward',
        'district',
        'city',
        'type',
        'is_default',
    ];

    /**
     * Ép kiểu dữ liệu (Casting)
     */
    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Mối quan hệ: Một địa chỉ thuộc về một Người dùng (User)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}