<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => number_format($this->price, 2),
            'stock_quantity' => $this->stock_quantity,
            'is_in_stock' => $this->stock_quantity > 0,
            'is_low_stock' => $this->isLowStock(),
            'image_url' => $this->image_url,
            'category' => $this->category ? [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ] : null,
        ];
    }
}
