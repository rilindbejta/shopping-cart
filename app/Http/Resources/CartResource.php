<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product' => [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'price' => number_format($this->product->price, 2),
                'stock_quantity' => $this->product->stock_quantity,
            ],
            'quantity' => $this->quantity,
            'subtotal' => number_format($this->quantity * $this->product->price, 2),
        ];
    }
}
