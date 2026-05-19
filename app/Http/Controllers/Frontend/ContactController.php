<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Contact page দেখাবে
    public function index()
    {
        return view('frontend.contact');
    }

    // Form submit হলে validate করে save করবে
    public function store(Request $request)
{
    $validated = $request->validate([
        'name'    => ['required', 'string', 'min:2', 'max:100', 'regex:/^[a-zA-Z\x{0980}-\x{09FF}\s]+$/u'],
        'email'   => 'required|email|max:150',
        'subject' => 'required|string|min:3|max:200',
        'message' => 'required|string|min:10|max:2000',
    ], [
        'name.required'    => 'Name is required.',
        'name.min'         => 'Name must be at least 2 characters long.',
        'name.regex'       => 'Name can only contain letters — numbers or symbols are not allowed.',
        'email.required'   => 'Email is required.',
        'email.email'      => 'Please enter a valid email address.',
        'subject.required' => 'Subject is required.',
        'subject.min'      => 'Subject must be at least 3 characters long.',
        'message.required' => 'Message is required.',
        'message.min'      => 'Message must be at least 10 characters long.',
    ]);

    ContactMessage::create($validated);

    // ✅ AJAX request → JSON response (no page reload)
    if ($request->expectsJson() || $request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent successfully! We will contact you soon.',
        ]);
    }

    // Normal fallback
    return back()->with('success', 'Your message has been sent successfully!');
}
}