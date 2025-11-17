<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'total_amount' => number_format($this->total_amount, 2),
            'status' => $this->status,
            'created_at' => $this->created_at->format('M d, Y h:i A'),
            'items' => OrderItemResource::collection($this->orderItems)->resolve(),
        ];
    }
}
