<?php

namespace App\Http\Requests;

use App\Models\Cart;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCartRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'quantity' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    $cart = $this->route('cart');

                    // If $cart is not a Cart instance, try to find it by ID
                    if (!$cart instanceof Cart) {
                        $cart = Cart::find($cart);
                    }

                    if ($cart && $cart->product && $value > $cart->product->stock_quantity) {
                        $fail("Only {$cart->product->stock_quantity} items available in stock.");
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'quantity.required' => 'Please specify the quantity.',
            'quantity.min' => 'Quantity must be at least 1.',
        ];
    }
}
