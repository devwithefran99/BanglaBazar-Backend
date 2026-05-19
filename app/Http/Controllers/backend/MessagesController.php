<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    // সব messages দেখাবে
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(15);
        return view('backend.messages.index', compact('messages'));
    }

    // একটা message বিস্তারিত দেখাবে + read mark করবে
    public function show(ContactMessage $message)
    {
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }
        return view('backend.messages.show', compact('message'));
    }

    // Message delete করবে
    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('backend.messages.index')
                         ->with('success', 'বার্তাটি মুছে ফেলা হয়েছে।');
    }

    // Unread count (sidebar badge এর জন্য)
    public static function unreadCount(): int
    {
        return ContactMessage::where('is_read', false)->count();
    }
}