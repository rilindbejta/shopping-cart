<?php

namespace App\Services;

use App\Exceptions\InsufficientStockException;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Collection;

class CartService
{
    public function getCartItems(User $user): Collection
    {
        return Cart::with('product')
            ->where('user_id', $user->id)
            ->get();
    }

    public function getCartTotal(User $user): float
    {
        return Cart::where('user_id', $user->id)
            ->with('product')
            ->get()
            ->sum(function ($cart) {
                return $cart->quantity * $cart->product->price;
            });
    }

    public function addToCart(User $user, int $product_id, int $quantity): Cart
    {
        $product = Product::findOrFail($product_id);

        // Check stock before adding
        if (!$product->isInStock($quantity)) {
            throw InsufficientStockException::forQuantity($quantity, $product->stock_quantity);
        }

        // Check if item already in cart
        $cart = Cart::where('user_id', $user->id)
            ->where('product_id', $product_id)
            ->first();

        if ($cart) {
            // Update existing cart item
            $newQuantity = $cart->quantity + $quantity;
            
            if (!$product->isInStock($newQuantity)) {
                throw InsufficientStockException::forQuantity($newQuantity, $product->stock_quantity);
            }

            $cart->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            $cart = Cart::create([
                'user_id' => $user->id,
                'product_id' => $product_id,
                'quantity' => $quantity,
            ]);
        }

        return $cart->load('product');
    }

    public function updateCart(Cart $cart, int $quantity): Cart
    {
        if (!$cart->product->isInStock($quantity)) {
            throw InsufficientStockException::forQuantity($quantity, $cart->product->stock_quantity);
        }

        $cart->quantity = $quantity;
        $cart->save();

        return $cart->load('product');
    }

    public function removeFromCart(Cart $cart): bool
    {
        return $cart->delete();
    }

    public function clearCart(User $user): bool
    {
        return Cart::where('user_id', $user->id)->delete() > 0;
    }
}

