<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {}

    public function index(): Response
    {
        $orders = $this->orderService->getUserOrders(auth()->user());

        return Inertia::render('Orders/Index', [
            'orders' => OrderResource::collection($orders)->resolve(),
        ]);
    }

    public function checkout(CheckoutRequest $request): RedirectResponse
    {
        try {
            $order = $this->orderService->createOrderFromCart(auth()->user());

            return redirect()->route('orders.index')
                ->with('success', "Order #{$order->id} placed successfully!");
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
