<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // সব reviews list
    public function index(Request $request)
    {
        $query = Review::with(['user'])
                       ->latest();

        // Status filter
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $reviews = $query->paginate(15);

        $stats = [
            'total'    => Review::count(),
            'pending'  => Review::where('status', 'pending')->count(),
            'approved' => Review::where('status', 'approved')->count(),
            'rejected' => Review::where('status', 'rejected')->count(),
        ];

        return view('backend.reviews.index', compact('reviews', 'stats'));
    }

    // Approve
    public function approve(Review $review)
    {
        $review->update(['status' => 'approved']);

        return back()->with('success', 'Review approved successfully.');
    }

    // Reject
    public function reject(Review $review)
    {
        $review->update(['status' => 'rejected']);

        return back()->with('success', 'Review rejected.');
    }

    // Delete
    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Review deleted.');
    }

    
    
    // Featured Toggle
public function toggleFeatured(Review $review)
{
    if ($review->status !== 'approved') {
        return response()->json([
            'success' => false,
            'message' => 'Only approved reviews can be featured.'
        ]);
    }

    $newValue = !$review->featured;
    $review->update(['featured' => $newValue]);

    return response()->json([
        'success'  => true,
        'featured' => $newValue,
        'message'  => $newValue ? 'Review added to homepage.' : 'Review removed from homepage.',
    ]);
}

}