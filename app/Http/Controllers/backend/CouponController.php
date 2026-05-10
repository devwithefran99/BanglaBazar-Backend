<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('backend.coupons.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'      => 'required|string|max:50|unique:coupons,code',
            'type'      => 'required|in:percent,fixed',
            'value'     => 'required|numeric|min:1',
            'min_order' => 'nullable|numeric|min:0',
            'max_uses'  => 'nullable|integer|min:0',
            'expires_at'=> 'nullable|date|after:today',
        ]);

        Coupon::create([
            'code'       => strtoupper($request->code),
            'type'       => $request->type,
            'value'      => $request->value,
            'min_order'  => $request->min_order ?? 0,
            'max_uses'   => $request->max_uses ?? 0,
            'expires_at' => $request->expires_at,
            'is_active'  => $request->has('is_active'),
        ]);

        return redirect()->route('backend.coupons.index')
                         ->with('success', 'Coupon তৈরি হয়েছে!');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('backend.coupons.index')
                         ->with('success', 'Coupon delete হয়েছে!');
    }

    public function toggle(Coupon $coupon)
    {
        $coupon->update(['is_active' => !$coupon->is_active]);
        return redirect()->route('backend.coupons.index')
                         ->with('success', 'Status update হয়েছে!');
    }
}