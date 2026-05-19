<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\EmailLog;
use App\Mail\OrderMail;
use App\Mail\CustomMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function index()
    {
        $logs      = EmailLog::with('user')->latest()->paginate(20);
        $customers = User::where('role', 'customer')->orWhereNull('role')->get(['id', 'name', 'email']);
        $orders    = Order::with('user')->latest()->take(50)->get();

        return view('backend.emails.index', compact('logs', 'customers', 'orders'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'to'      => 'required|email',
            'subject' => 'required|string|max:255',
            'body'    => 'required|string',
        ]);

        try {
            Mail::to($request->to)->send(new CustomMail(
                subject: $request->subject,
                body:    $request->body,
                name:    $request->to_name ?? '',
            ));

            EmailLog::create([
                'to_email' => $request->to,
                'to_name'  => $request->to_name ?? '',
                'subject'  => $request->subject,
                'body'     => $request->body,
                'type'     => 'custom',
                'status'   => 'sent',
                'user_id'  => optional(User::where('email', $request->to)->first())->id,
            ]);

            return back()->with('success', 'Email sent to ' . $request->to);

        } catch (\Exception $e) {
            EmailLog::create([
                'to_email' => $request->to,
                'to_name'  => $request->to_name ?? '',
                'subject'  => $request->subject,
                'body'     => $request->body,
                'type'     => 'custom',
                'status'   => 'failed',
                'error'    => $e->getMessage(),
            ]);

            return back()->with('error', 'Email failed: ' . $e->getMessage());
        }
    }

    public function resendOrderMail(Request $request, $orderId)
    {
        $request->validate([
            'mail_type' => 'required|in:placed,confirmed,shipped,delivered,cancelled',
        ]);

        $order = Order::with(['user', 'items'])->findOrFail($orderId);

        if (!$order->user || !$order->user->email) {
            return back()->with('error', 'Customer email not found.');
        }

        try {
            Mail::to($order->user->email)->send(new OrderMail($order, $request->mail_type));
            return back()->with('success', 'Email re-sent to ' . $order->user->email);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed: ' . $e->getMessage());
        }
    }

    public function destroy(EmailLog $emailLog)
    {
        $emailLog->delete();
        return back()->with('success', 'Log deleted.');
    }
}