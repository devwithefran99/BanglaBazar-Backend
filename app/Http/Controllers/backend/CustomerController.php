<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;

class CustomerController extends Controller
{
    public function index()
    {
        // শুধু customer role এর users দেখাবে, admin দেখাবে না
        $customers = User::where('role', 'customer')
            ->withCount(['orders', 'wishlists', 'carts'])
            ->latest()
            ->paginate(15);

        return view('backend.customers.index', compact('customers'));
    }

    public function show(User $user)
    {
        // Admin কে কখনো customer হিসেবে দেখাবে না
        if ($user->role === 'admin') {
            return redirect()->route('backend.customers.index')
                ->with('error', 'Admin users cannot be viewed here.');
        }

        $user->load([
            'orders.items',
            'wishlists',
            'carts',
        ]);

        return view('backend.customers.show', compact('user'));
    }
}