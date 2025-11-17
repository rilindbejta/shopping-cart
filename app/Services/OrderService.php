<?php

namespace App\Services;

use App\Exceptions\EmptyCartException;
use App\Exceptions\InsufficientStockException;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    public function __construct(
        private CartService $cartService
    ) {}

    public function createOrderFromCart(User $user): Order
    {
        return DB::transaction(function () use ($user) {
            $cartItems = $this->cartService->getCartItems($user);

            if ($cartItems->isEmpty()) {
                throw new EmptyCartException();
            }

            foreach ($cartItems as $cartItem) {
                if (!$cartItem->product->isInStock($cartItem->quantity)) {
                    throw InsufficientStockException::forProduct(
                        $cartItem->product->name,
                        $cartItem->product->stock_quantity
                    );
                }
            }

            // Calculate total
            $total = $cartItems->sum(function ($cartItem) {
                return $cartItem->quantity * $cartItem->product->price;
            });

            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $total,
                'status' => 'completed',
            ]);

            // Create order items and decrease stock
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);

                $cartItem->product->decreaseStock($cartItem->quantity);
            }

            $this->cartService->clearCart($user);

            Log::info('Order created', ['order_id' => $order->id, 'user_id' => $user->id]);

            return $order->load('orderItems.product');
        });
    }

    /**
     * Get all orders for a user.
     */
    public function getUserOrders(User $user): Collection
    {
        return Order::with('orderItems.product')
            ->where('user_id', $user->id)
            ->latest()
            ->get();
    }

    /**
     * Get daily sales report data.
     */
    public function getDailySalesReport(string $date): array
    {
        $orders = Order::with('orderItems.product')
            ->whereDate('created_at', $date)
            ->where('status', 'completed')
            ->get();

        $totalRevenue = $orders->sum('total_amount');
        $totalProductsSold = $orders->sum(function ($order) {
            return $order->orderItems->sum('quantity');
        });

        // Group products sold
        $productsSold = [];
        foreach ($orders as $order) {
            foreach ($order->orderItems as $item) {
                $productName = $item->product->name;
                if (!isset($productsSold[$productName])) {
                    $productsSold[$productName] = [
                        'name' => $productName,
                        'quantity' => 0,
                        'revenue' => 0,
                    ];
                }
                $productsSold[$productName]['quantity'] += $item->quantity;
                $productsSold[$productName]['revenue'] += $item->quantity * $item->price;
            }
        }

        return [
            'date' => $date,
            'total_orders' => $orders->count(),
            'total_products_sold' => $totalProductsSold,
            'total_revenue' => $totalRevenue,
            'products_sold' => array_values($productsSold),
        ];
    }
}

