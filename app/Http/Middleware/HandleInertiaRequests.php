<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        $cartCount = $request->user()
            ? Cart::where('user_id', $request->user()->id)->sum('quantity')
            : 0;

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'cartCount' => $cartCount,
            ],
            'flash' => [
                'success' => fn() => session('success'),
                'error' => fn() => session('error'),
            ],
        ];
    }
}
