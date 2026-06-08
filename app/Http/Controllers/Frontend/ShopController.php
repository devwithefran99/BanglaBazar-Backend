<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\HotDeal;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    // Category list একজায়গায় রাখো
    const CATEGORIES = [
        'sutki'    => 'Sutki',
        'meat'     => 'Meat',
        'fish'     => 'Fish',
        'oil_ghee' => 'Oil & Ghee',
        'spices'   => 'Spices',
        'rice'     => 'Rice',
        'beverage' => 'Beverage',
    ];

    public function index(Request $request)
    {
        $selectedCategory = $request->query('category', 'all');

        $productsQuery = Product::where('is_active', true)->with('variations')->latest();
$hotDealsQuery = HotDeal::where('is_active', true)->with('variations')->latest();

        // Category filter
        if ($selectedCategory !== 'all') {
            $productsQuery->where('category', $selectedCategory);
            $hotDealsQuery->where('category', $selectedCategory);
        }
        
$searchText = $request->query('search');
if ($searchText) {
    $productsQuery->where('name', 'like', '%' . $searchText . '%');
    $hotDealsQuery->where('name', 'like', '%' . $searchText . '%');
}

$perPage = 12;
$page    = $request->query('page', 1);

$allProductItems = collect($productsQuery->get()->map(fn($p) => ['type' => 'product', 'item' => $p])->all());
$allHotDealItems = collect($hotDealsQuery->get()->map(fn($h) => ['type' => 'hotdeal', 'item' => $h])->all());

// Sort order query
$sortBy = $request->query('sort', 'latest');
$merged = $allProductItems->merge($allHotDealItems);

if ($sortBy === 'name') {
    $merged = $merged->sortBy(fn($r) => $r['item']->name);
}

// Manual paginate
$total    = $merged->count();
$offset   = ($page - 1) * $perPage;
$sliced   = $merged->slice($offset, $perPage)->values();

$paginatedItems = new \Illuminate\Pagination\LengthAwarePaginator(
    $sliced->values()->all(),
    $total,
    $perPage,
    $page,
    ['path' => $request->url(), 'query' => $request->except('page')]
);
// Blade এর জন্য আলাদা করো
$products = $sliced->where('type', 'product')->pluck('item');
$hotDeals = $sliced->where('type', 'hotdeal')->pluck('item');

        // Sidebar এর count এর জন্য সব data
        $allProducts = Product::where('is_active', true)->get();
        $allHotDeals = HotDeal::where('is_active', true)->get();

         $dbCategories = Category::where('is_active', true)
                            ->orderBy('sort_order')
                            ->get();

        if (Auth::check()) {
            Auth::user()->load('wishlists');
        }

       return view('frontend.shop', compact(
    'products',
    'hotDeals',
    'allProducts',
    'allHotDeals',
    'selectedCategory',
    'dbCategories',
    'paginatedItems',
    'total'
));
    }

    /**
     * Nav Search API — 3+ letter lazy search
     * Returns: [ { id, name, category, type, image } ]
     */
    public function searchSuggestions(Request $request)
    {
        $q = trim($request->query('q', ''));

        // 3 letter এর কম হলে empty return
        if (mb_strlen($q) < 3) {
            return response()->json([]);
        }

        // Products search (max 5)
        $products = Product::where('is_active', true)
            ->where('name', 'like', '%' . $q . '%')
            ->select('id', 'name', 'category', 'image', 'price')
            ->limit(5)
            ->get()
            ->map(fn($p) => [
                'id'       => $p->id,
                'name'     => $p->name,
                'category' => $p->category,
                'type'     => 'product',
                'image'    => $p->image ? asset('storage/' . $p->image) : asset('frontend/image/Product Image (1).png'),
                'price'    => '৳' . number_format($p->price, 0),
            ]);

        // HotDeals search (max 3)
        $hotDeals = HotDeal::where('is_active', true)
            ->where('name', 'like', '%' . $q . '%')
            ->select('id', 'name', 'category', 'image', 'price')
            ->limit(3)
            ->get()
            ->map(fn($h) => [
                'id'       => $h->id,
                'name'     => $h->name,
                'category' => $h->category,
                'type'     => 'hotdeal',
                'image'    => $h->image ? asset('storage/' . $h->image) : asset('frontend/image/Product Image (1).png'),
                'price'    => '৳' . number_format($h->price, 0),
            ]);

        $results = $products->merge($hotDeals)->take(8)->values();

        return response()->json($results);
    }
}