<?php
namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    public function index()
    {
        $pendingOrders = Order::where('status', 'pending')
                            ->with(['orderItems.menuItem', 'table'])
                            ->latest()->get();

        $cookingOrders = Order::where('status', 'cooking')
                            ->with(['orderItems.menuItem', 'table'])
                            ->latest()->get();

        $readyOrders = Order::where('status', 'ready')
                            ->with(['orderItems.menuItem', 'table'])
                            ->latest()->get();

        return view('staff.kitchen',
            compact('pendingOrders', 'cookingOrders', 'readyOrders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = ['status' => $request->status];

        if ($request->status === 'cooking') {
            $data['cooking_started_at'] = now();
        } elseif ($request->status === 'ready') {
            $data['ready_at'] = now();
        }

        $order->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Order #'.$order->id.' updated to '.
                         ucfirst($request->status)
        ]);
    }

    public function liveOrders()
    {
        $pending = Order::where('status', 'pending')
                    ->with(['orderItems.menuItem', 'table'])
                    ->latest()->get();

        $cooking = Order::where('status', 'cooking')
                    ->with(['orderItems.menuItem', 'table'])
                    ->latest()->get();

        $ready = Order::where('status', 'ready')
                    ->with(['orderItems.menuItem', 'table'])
                    ->latest()->get();

        return response()->json([
            'pending' => $pending,
            'cooking' => $cooking,
            'ready'   => $ready,
            'counts'  => [
                'pending' => $pending->count(),
                'cooking' => $cooking->count(),
                'ready'   => $ready->count(),
            ]
        ]);
    }
}