<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(): Response
    {
        // Get all products ordered alphabetically
        $products = Product::orderBy('name')->get();

        return Inertia::render('Products/Index', [
            'products' => ProductResource::collection($products)->resolve(),
        ]);
    }
}
