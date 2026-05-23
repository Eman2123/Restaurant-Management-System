<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);

        $existing = Review::where('order_id', $order->id)
                          ->where('user_id', auth()->id())
                          ->first();

        if ($existing) {
            return redirect()->route('customer.orders')
                   ->with('error', 'You already reviewed this order!');
        }

        return view('customer.review', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);

        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'comment'  => 'nullable|string|max:500',
            'category' => 'required|in:food,service,ambiance,value',
        ]);

        Review::create([
            'user_id'  => auth()->id(),
            'order_id' => $order->id,
            'rating'   => $request->rating,
            'comment'  => $request->comment,
            'category' => $request->category,
        ]);

        return redirect()->route('customer.orders')
               ->with('success', 'Thank you for your review!');
    }
}