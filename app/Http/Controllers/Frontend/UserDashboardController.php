<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ReturnRequest;
use Illuminate\Http\Request;
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

    public function updateProfile(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name'   => 'required|string|max:100',
        'phone'  => 'nullable|string|max:20',
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $data = [
        'name'  => $request->name,
        'phone' => $request->phone,
    ];

    if ($request->hasFile('avatar')) {
        // পুরনো avatar delete করো
        if ($user->avatar) {
            \Storage::disk('public')->delete($user->avatar);
        }
        $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
    }

    $user->update($data);

    return response()->json(['success' => true, 'message' => 'Profile updated successfully.']);
}

public function updateAddress(Request $request)
{
    $request->validate([
        'address' => 'required|string|max:255',
    ]);

    Auth::user()->update([
        'address' => $request->address,
    ]);

    return response()->json(['success' => true, 'message' => 'Address updated successfully.']);
}
}