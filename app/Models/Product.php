<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;
use App\Jobs\LowStockNotificationJob;

class Product extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price',
        'stock_quantity',
        'description',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock_quantity' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::updated(function (Product $product) {
            // Check if stock quantity was updated and is now low
            if ($product->wasChanged('stock_quantity') && $product->isLowStock()) {
                Log::info('Low stock detected for product: ' . $product->name);
                LowStockNotificationJob::dispatch($product);
            }
        });
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function isLowStock(int $threshold = 5): bool
    {
        return $this->stock_quantity < $threshold;
    }

    public function isInStock(int $quantity = 1): bool
    {
        return $this->stock_quantity >= $quantity;
    }

    public function decreaseStock(int $quantity): bool
    {
        if (!$this->isInStock($quantity)) {
            return false;
        }

        $this->stock_quantity -= $quantity;
        return $this->save();
    }
}
