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
    if ($user->role === 'admin') {
        return redirect()->route('backend.customers.index')
            ->with('error', 'Admin users cannot be viewed here.');
    }

    // orders ঠিকঠাক আছে
    $user->load(['orders.items.product']);

    // carts & wishlists — product_type conditional, তাই manually resolve
    $user->load(['carts', 'wishlists']);

    foreach ($user->carts as $cart) {
        $productModel = $cart->product_type === 'hotdeal'
            ? \App\Models\HotDeal::find($cart->product_id)
            : \App\Models\Product::find($cart->product_id);
        $cart->setRelation('product', $productModel);
    }

    foreach ($user->wishlists as $wishlist) {
        $productModel = $wishlist->product_type === 'hotdeal'
            ? \App\Models\HotDeal::find($wishlist->product_id)
            : \App\Models\Product::find($wishlist->product_id);
        $wishlist->setRelation('product', $productModel);
    }

    return view('backend.customers.show', compact('user'));
}
}