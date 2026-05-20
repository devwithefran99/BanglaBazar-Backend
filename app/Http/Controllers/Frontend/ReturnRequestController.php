<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ReturnRequest;
use App\Models\Order;
use App\Mail\CustomMail;
use App\Models\EmailLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ReturnRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_id'    => 'required|exists:orders,id',
            'type'        => 'required|in:return,refund',
            'reason'      => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $order = Order::where('id', $request->order_id)
                      ->where('user_id', Auth::id())
                      ->where('status', 'delivered')
                      ->firstOrFail();

        // একটা order এ একটাই active request
        $exists = ReturnRequest::where('order_id', $order->id)
                               ->whereIn('status', ['pending', 'approved'])
                               ->exists();
        if ($exists) {
            return back()->with('error', 'You already have an active request for this order.');
        }

        ReturnRequest::create([
            'order_id'    => $order->id,
            'user_id'     => Auth::id(),
            'type'        => $request->type,
            'reason'      => $request->reason,
            'description' => $request->description,
        ]);

        // Admin কে email notification
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $subject = '🔄 New ' . ucfirst($request->type) . ' Request — Order #' . str_pad($order->id, 4, '0', STR_PAD_LEFT);
            $body = "Customer: " . Auth::user()->name . "\n"
                  . "Order: #" . str_pad($order->id, 4, '0', STR_PAD_LEFT) . "\n"
                  . "Type: " . ucfirst($request->type) . "\n"
                  . "Reason: " . $request->reason;

            try {
                Mail::to($admin->email)->send(new CustomMail($subject, $body, $admin->name));
                EmailLog::create([
                    'to_email' => $admin->email,
                    'to_name'  => $admin->name,
                    'subject'  => $subject,
                    'body'     => $body,
                    'type'     => 'return_request',
                    'status'   => 'sent',
                    'user_id'  => $admin->id,
                ]);
            } catch (\Exception $e) {}
        }

        return back()->with('success', 'Your ' . $request->type . ' request has been submitted!');
    }
}