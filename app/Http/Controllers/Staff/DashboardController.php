<?php
namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $pendingOrders = Order::where('status', 'pending')
                            ->with(['orderItems.menuItem', 'table'])
                            ->latest()->get();

        $cookingOrders = Order::where('status', 'cooking')
                            ->with(['orderItems.menuItem', 'table'])
                            ->latest()->get();

        return view('staff.dashboard',
                    compact('pendingOrders', 'cookingOrders'));
    }
}