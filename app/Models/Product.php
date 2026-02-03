<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductVariant;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'slug',
        'description',
        'base_price_cents',
        'image_url',
        'type',
        'is_spicy',
        'is_available'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
