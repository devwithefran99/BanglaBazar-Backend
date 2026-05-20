<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ReturnRequest;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $user->load([
            'orders' => function($q) { $q->latest()->take(10); },
            'orders.items',
            'wishlists',
            'carts',
        ]);

        // Delivered orders যেগুলোতে এখনো active return request নেই
        $deliveredOrders = $user->orders->where('status', 'delivered');

        // User এর সব return requests
        $returnRequests = ReturnRequest::with('order')
                            ->where('user_id', Auth::id())
                            ->latest()
                            ->get();

        return view('frontend.userdashboard', compact('user', 'deliveredOrders', 'returnRequests'));
    }
}