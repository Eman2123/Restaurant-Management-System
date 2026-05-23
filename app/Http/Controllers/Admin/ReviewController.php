<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'order'])
                    ->latest()->get();

        $stats = [
            'total'   => $reviews->count(),
            'avg'     => round($reviews->avg('rating'), 1),
            'five'    => $reviews->where('rating', 5)->count(),
            'four'    => $reviews->where('rating', 4)->count(),
            'three'   => $reviews->where('rating', 3)->count(),
        ];

        return view('admin.reviews.index',
                    compact('reviews', 'stats'));
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Review deleted!');
    }
}