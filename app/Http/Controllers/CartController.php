<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    public function __construct(
        private CartService $cartService
    ) {}

    public function index(): Response
    {
        $cartItems = $this->cartService->getCartItems(auth()->user());

        return Inertia::render('Cart/Index', [
            'cartItems' => CartResource::collection($cartItems)->resolve(),
            'total' => number_format($this->cartService->getCartTotal(auth()->user()), 2),
        ]);
    }

    public function store(AddToCartRequest $request): RedirectResponse
    {
        try {
            $this->cartService->addToCart(
                auth()->user(),
                $request->product_id,
                $request->quantity ?? 1
            );

            return back()->with('success', 'Product added to cart!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update(UpdateCartRequest $request, Cart $cart): RedirectResponse
    {
        try {
            $this->cartService->updateCart($cart, $request->quantity);

            return back()->with('success', 'Cart updated!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Cart $cart): RedirectResponse
    {
        abort_unless($cart->user_id === auth()->id(), 403);

        $this->cartService->removeFromCart($cart);

        return back()->with('success', 'Item removed from cart!');
    }
}
