<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Product::with('category');

        // Search by product name
        if ($search = $request->get('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Filter by category
        if ($categoryId = $request->get('category')) {
            $query->where('category_id', $categoryId);
        }

        $sortBy = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');

        $query->orderBy($sortBy, $sortDirection);

        // Paginate results
        $products = $query->paginate(12)->withQueryString();

        // Get all categories to show on filter dropdown
        $categories = Category::orderBy('name')->get(['id', 'name', 'slug']);

        return Inertia::render('Products/Index', [
            'products' => ProductResource::collection($products->items())->resolve(),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'links' => $products->linkCollection()->toArray(),
            ],
            'categories' => $categories,
            'filters' => [
                'search' => $search,
                'category' => $categoryId,
                'sort' => $sortBy,
                'direction' => $sortDirection,
            ],
        ]);
    }
}
