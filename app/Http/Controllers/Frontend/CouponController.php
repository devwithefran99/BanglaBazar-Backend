<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate([
            'code'  => 'required|string',
            'total' => 'required|numeric',
        ]);

        $coupon = Coupon::where('code', strtoupper($request->code))
                        ->first();

        if (!$coupon) {
            return response()->json([
                'valid'   => false,
                'message' => 'Invalid coupon code!'
            ]);
        }

        $result = $coupon->isValid((float) $request->total);

        if (!$result['valid']) {
            return response()->json($result);
        }

        $discount = $coupon->calculateDiscount((float) $request->total);
        $newTotal = max(0, $request->total - $discount);

        return response()->json([
            'valid'    => true,
            'message'  => '🎉 ' . $coupon->code . ' applied! ৳' . number_format($discount, 2) . ' discount পেয়েছেন।',
            'discount' => $discount,
            'newTotal' => $newTotal,
            'type'     => $coupon->type,
            'value'    => $coupon->value,
        ]);
    }
}