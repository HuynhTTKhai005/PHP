<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product; // <-- Thêm dòng này

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'variant_name', // ví dụ size, color...
        'stock',
        'price_override', // nếu giá khác sản phẩm gốc
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
