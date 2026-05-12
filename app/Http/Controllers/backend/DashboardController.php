<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Inventory;

class DashboardController extends Controller
{
    public function index()
    {
        // existing stats
        $totalProducts    = Product::count();
        $activeProducts   = Product::where('is_active', true)->count();
        $featuredProducts = Product::where('is_featured', true)->count();
        $outOfStock       = Product::where('stock', 0)->count();

        // inventory profit stats
        $inventoryStats = Inventory::selectRaw('
            SUM(stock * buy_price)                    as total_investment,
            SUM(stock * price)                        as total_sell_value,
            SUM(stock * (price - buy_price))          as total_potential_profit,
            AVG(CASE WHEN price > 0
                THEN ((price - buy_price) / price) * 100
                ELSE 0 END)                           as avg_margin
        ')->first();

        return view('backend.dashboard.dashboardIndex', [
            'totalProducts'          => $totalProducts,
            'activeProducts'         => $activeProducts,
            'featuredProducts'       => $featuredProducts,
            'outOfStock'             => $outOfStock,
            'totalInvestment'        => round($inventoryStats->total_investment ?? 0, 2),
            'totalSellValue'         => round($inventoryStats->total_sell_value ?? 0, 2),
            'totalPotentialProfit'   => round($inventoryStats->total_potential_profit ?? 0, 2),
            'avgMargin'              => round($inventoryStats->avg_margin ?? 0, 1),
        ]);
    }
}