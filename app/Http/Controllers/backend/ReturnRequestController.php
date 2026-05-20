<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ReturnRequest;
use App\Mail\CustomMail;
use App\Models\EmailLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReturnRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = ReturnRequest::with(['user', 'order'])->latest();

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $requests = $query->paginate(15);

        $stats = [
            'total'    => ReturnRequest::count(),
            'pending'  => ReturnRequest::where('status', 'pending')->count(),
            'approved' => ReturnRequest::where('status', 'approved')->count(),
            'rejected' => ReturnRequest::where('status', 'rejected')->count(),
        ];

        return view('backend.returns.index', compact('requests', 'stats'));
    }

    public function show($id)
    {
        $returnRequest = ReturnRequest::with(['user', 'order.items'])->findOrFail($id);
        return view('backend.returns.show', compact('returnRequest'));
    }

    public function action(Request $request, $id)
    {
        $request->validate([
            'status'     => 'required|in:approved,rejected',
            'admin_note' => 'nullable|string|max:500',
        ]);

        $returnRequest = ReturnRequest::with(['user', 'order'])->findOrFail($id);
        $returnRequest->update([
            'status'     => $request->status,
            'admin_note' => $request->admin_note,
        ]);

        // Customer কে email notification
        $customer = $returnRequest->user;
        if ($customer && $customer->email) {
            $emoji   = $request->status === 'approved' ? '✅' : '❌';
            $subject = $emoji . ' Your ' . ucfirst($returnRequest->type) . ' Request — '
                     . ucfirst($request->status);
            $body    = "Hi " . $customer->name . ",\n\n"
                     . "Your " . $returnRequest->type . " request for Order #"
                     . str_pad($returnRequest->order_id, 4, '0', STR_PAD_LEFT)
                     . " has been " . $request->status . ".\n\n"
                     . ($request->admin_note ? "Admin Note: " . $request->admin_note : '');

            try {
                Mail::to($customer->email)->send(new CustomMail($subject, $body, $customer->name));
                EmailLog::create([
                    'to_email' => $customer->email,
                    'to_name'  => $customer->name,
                    'subject'  => $subject,
                    'body'     => $body,
                    'type'     => 'return_' . $request->status,
                    'status'   => 'sent',
                    'user_id'  => $customer->id,
                ]);
            } catch (\Exception $e) {}
        }

        return redirect()->route('backend.emails.index', [
    'prefill_to'      => $customer->email ?? '',
    'prefill_to_name' => $customer->name ?? '',
    'prefill_subject' => $emoji . ' Your ' . ucfirst($returnRequest->type) . ' Request — ' . ucfirst($request->status),
    'prefill_body'    => "Hi " . ($customer->name ?? '') . ",\n\nYour " . $returnRequest->type . " request for Order #" . str_pad($returnRequest->order_id, 4, '0', STR_PAD_LEFT) . " has been " . $request->status . ".\n\n" . ($request->admin_note ? "Note: " . $request->admin_note : ''),
])->with('success', 'Request ' . $request->status . '. Now send email to customer.');
    }
}