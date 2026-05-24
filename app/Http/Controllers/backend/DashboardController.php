<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\HotDeal;
use App\Models\User;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ── KPI Cards ────────────────────────────────────────────
        $todayOrders     = Order::whereDate('created_at', today())->count();
        $yesterdayOrders = Order::whereDate('created_at', today()->subDay())->count();
        $todayVsYesterday = $yesterdayOrders > 0
            ? round((($todayOrders - $yesterdayOrders) / $yesterdayOrders) * 100)
            : 0;

        $thisMonthRevenue = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->whereNotIn('status', ['cancelled'])
            ->sum('total_price');

        $lastMonthRevenue = Order::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->whereNotIn('status', ['cancelled'])
            ->sum('total_price');

        $revenueGrowth = $lastMonthRevenue > 0
            ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100)
            : 0;

        $totalCustomers  = User::where('role', 'customer')->orWhereNull('role')->count();
        $newCustomers    = User::where('role', 'customer')
            ->orWhereNull('role')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        $outOfStock      = Product::where('stock', 0)->count()
                         + HotDeal::where('stock', 0)->count();

        $pendingOrders   = Order::where('status', 'pending')->count();

        // ── Order Status Overview ─────────────────────────────────
        $orderStatus = [
            'pending'   => Order::where('status', 'pending')->count(),
            'confirmed' => Order::where('status', 'confirmed')->count(),
            'shipped'   => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];
        $totalOrders = array_sum($orderStatus);

        // ── Weekly Sales (last 7 days) ────────────────────────────
        $weeklySales = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $weeklySales[] = [
                'label'   => $date->format('D'),
                'orders'  => Order::whereDate('created_at', $date)->count(),
                'revenue' => (float) Order::whereDate('created_at', $date)
                    ->whereNotIn('status', ['cancelled'])
                    ->sum('total_price'),
            ];
        }

        // ── Monthly Sales (last 12 months) ───────────────────────
        $monthlySales = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlySales[] = [
                'label'   => $date->format('M'),
                'orders'  => Order::whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->count(),
                'revenue' => (float) Order::whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->whereNotIn('status', ['cancelled'])
                    ->sum('total_price'),
            ];
        }

        // ── Top Selling Products ──────────────────────────────────
        $topProducts = OrderItem::select(
                'product_id',
                'product_type',
                'product_name',
                DB::raw('SUM(quantity) as total_qty'),
                DB::raw('SUM(quantity * price) as total_revenue')
            )
            ->whereHas('order', fn($q) => $q->whereNotIn('status', ['cancelled']))
            ->groupBy('product_id', 'product_type', 'product_name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                $model = $item->product_type === 'hotdeal'
                    ? HotDeal::find($item->product_id)
                    : Product::find($item->product_id);
                $item->image = $model?->image ?? null;
                return $item;
            });

        // ── Recent Orders ─────────────────────────────────────────
        $recentOrders = Order::with('user')
            ->latest()
            ->limit(6)
            ->get();

        // ── Inventory & Finance ───────────────────────────────────
        $inventoryStats = Inventory::selectRaw('
            SUM(stock * buy_price)           as total_investment,
            SUM(stock * price)               as total_sell_value,
            SUM(stock * (price - buy_price)) as total_profit,
            AVG(CASE WHEN price > 0 THEN ((price - buy_price) / price) * 100 ELSE 0 END) as avg_margin
        ')->first();

        $lowStockItems = Inventory::where('stock', '>', 0)
            ->whereColumn('stock', '<=', 'min_stock')
            ->orderBy('stock')
            ->limit(3)
            ->get();

        $outOfStockInventory = Inventory::where('stock', 0)->count();

        return view('backend.dashboard.dashboardIndex', compact(
            // KPI
            'todayOrders', 'todayVsYesterday',
            'thisMonthRevenue', 'revenueGrowth',
            'totalCustomers', 'newCustomers',
            'outOfStock', 'pendingOrders',
            // Charts
            'orderStatus', 'totalOrders',
            'weeklySales', 'monthlySales',
            // Tables
            'topProducts', 'recentOrders',
            // Inventory
            'inventoryStats', 'lowStockItems', 'outOfStockInventory'
        ));
    }
}