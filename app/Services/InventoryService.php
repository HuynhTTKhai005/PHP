<?php

namespace App\Services;

use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Validation\ValidationException;

class InventoryService
{
    public function stockOutForOrder(Product $product, int $quantity, ?string $reason = null, ?string $note = null): ProductVariant
    {
        if ($quantity <= 0) {
            throw ValidationException::withMessages([
                'quantity' => 'Số lượng xuất kho phải lớn hơn 0.',
            ]);
        }

        $variant = $this->resolveVariantForProduct($product);
        $variant->refresh();

        if ($variant->stock_quantity < $quantity) {
            throw ValidationException::withMessages([
                'stock' => "Sản phẩm {$product->name} không đủ tồn kho.",
            ]);
        }

        $variant->decrement('stock_quantity', $quantity);
        $variant->refresh();
        $this->syncProductStock($product);

        InventoryTransaction::create([
            'product_id' => $product->id,
            'variant_id' => $variant->id,
            'type' => 'out',
            'change_quantity' => -$quantity,
            'current_stock' => $variant->stock_quantity,
            'reason' => $reason ?: 'order',
            'note' => $note,
            'performed_at' => now(),
        ]);

        return $variant;
    }

    public function stockIn(Product $product, int $quantity, ?string $reason = null, ?string $note = null): ProductVariant
    {
        if ($quantity <= 0) {
            throw ValidationException::withMessages([
                'quantity' => 'Số lượng nhập kho phải lớn hơn 0.',
            ]);
        }

        $variant = $this->resolveVariantForProduct($product);
        $variant->increment('stock_quantity', $quantity);
        $variant->refresh();
        $this->syncProductStock($product);

        InventoryTransaction::create([
            'product_id' => $product->id,
            'variant_id' => $variant->id,
            'type' => 'in',
            'change_quantity' => $quantity,
            'current_stock' => $variant->stock_quantity,
            'reason' => $reason ?: 'stock_in',
            'note' => $note,
            'performed_at' => now(),
        ]);

        return $variant;
    }

    public function syncProductStock(Product $product): void
    {
        $total = (int) $product->variants()->sum('stock_quantity');
        $product->update(['stock' => $total]);
    }

    private function resolveVariantForProduct(Product $product): ProductVariant
    {
        $variant = $product->variants()->orderBy('id')->first();
        if ($variant) {
            return $variant;
        }

        return $product->variants()->create([
            'sku' => 'SKU-'.$product->id.'-'.now()->timestamp,
            'name' => 'Mặc định',
            'price_adjustment' => 0,
            'stock_quantity' => max(0, (int) $product->stock),
        ]);
    }
}
