<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\MenuItem;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders'       => Order::count(),
            'pending_orders'     => Order::where('status', 'pending')->count(),
            'cooking_orders'     => Order::where('status', 'cooking')->count(),
            'total_reservations' => Reservation::count(),
            'pending_reservations' => Reservation::where('status', 'pending')->count(),
            'total_menu_items'   => MenuItem::count(),
            'total_users'        => User::count(),
            'total_customers'    => User::where('role', 'customer')->count(),
            'today_revenue'      => Order::whereDate('created_at', today())
                                        ->where('payment_status', 'paid')
                                        ->sum('total_amount'),
            'month_revenue'      => Order::whereMonth('created_at', now()->month)
                                        ->where('payment_status', 'paid')
                                        ->sum('total_amount'),
        ];

        $recentOrders = Order::with(['user', 'table'])
                            ->latest()->take(5)->get();

        $recentReservations = Reservation::with('table')
                                ->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentReservations'));
    }
}