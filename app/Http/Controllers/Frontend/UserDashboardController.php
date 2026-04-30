<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user->load(['orders.items', 'wishlists', 'carts']);
        return view('frontend.userdashboard', compact('user'));
    }
}