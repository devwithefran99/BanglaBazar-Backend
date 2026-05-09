<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ✅ orders এর সাথে items ও load করো
        $user->load([
            'orders' => function($q) {
                $q->latest()->take(10);
            },
            'orders.items',
            'wishlists',
            'carts',
        ]);

        return view('frontend.userdashboard', compact('user'));
    }
}