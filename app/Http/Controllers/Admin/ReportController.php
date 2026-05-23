<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Revenue by day (last 7 days)
        $dailyRevenue = [];
        $dailyLabels  = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dailyLabels[]  = $date->format('d M');
            $dailyRevenue[] = Order::whereDate('created_at', $date)
                                ->where('payment_status', 'paid')
                                ->sum('total_amount');
        }

        // Revenue by month (last 6 months)
        $monthlyRevenue = [];
        $monthlyLabels  = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyLabels[]  = $date->format('M Y');
            $monthlyRevenue[] = Order::whereYear('created_at', $date->year)
                                    ->whereMonth('created_at', $date->month)
                                    ->where('payment_status', 'paid')
                                    ->sum('total_amount');
        }

        // Top selling items
        $topItems = OrderItem::with('menuItem')
                    ->selectRaw('menu_item_id,
                                 SUM(quantity) as total_qty,
                                 SUM(subtotal) as total_revenue')
                    ->groupBy('menu_item_id')
                    ->orderByDesc('total_qty')
                    ->take(5)->get();

        // Order status breakdown
        $statusBreakdown = [
            'pending'   => Order::where('status', 'pending')->count(),
            'cooking'   => Order::where('status', 'cooking')->count(),
            'ready'     => Order::where('status', 'ready')->count(),
            'served'    => Order::where('status', 'served')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        // Summary stats
        $stats = [
            'total_revenue'   => Order::where('payment_status', 'paid')
                                      ->sum('total_amount'),
            'today_revenue'   => Order::whereDate('created_at', today())
                                      ->where('payment_status', 'paid')
                                      ->sum('total_amount'),
            'month_revenue'   => Order::whereMonth('created_at', now()->month)
                                      ->where('payment_status', 'paid')
                                      ->sum('total_amount'),
            'total_orders'    => Order::count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'avg_order'       => Order::where('payment_status', 'paid')
                                      ->avg('total_amount') ?? 0,
        ];

        return view('admin.reports.index', compact(
            'dailyRevenue', 'dailyLabels',
            'monthlyRevenue', 'monthlyLabels',
            'topItems', 'statusBreakdown', 'stats'
        ));
    }
    public function daily(Request $request)
    {
        $date = $request->date ?? today()->toDateString();

        $orders = Order::whereDate('created_at', $date)
                    ->with(['orderItems.menuItem', 'user'])
                    ->get();

        $summary = [
            'date'          => $date,
            'total_orders'  => $orders->count(),
            'total_revenue' => $orders->where('payment_status','paid')
                                    ->sum('total_amount'),
            'paid_orders'   => $orders->where('payment_status','paid')->count(),
            'unpaid_orders' => $orders->where('payment_status','unpaid')->count(),
            'cancelled'     => $orders->where('status','cancelled')->count(),
            'served'        => $orders->where('status','served')->count(),
            'dine_in'       => $orders->where('order_type','dine_in')->count(),
            'takeaway'      => $orders->where('order_type','takeaway')->count(),
            'delivery'      => $orders->where('order_type','delivery')->count(),
        ];

        // Top items today
        $topItems = \App\Models\OrderItem::whereHas('order', function($q) use ($date) {
                        $q->whereDate('created_at', $date);
                    })
                    ->with('menuItem')
                    ->selectRaw('menu_item_id,
                                SUM(quantity) as total_qty,
                                SUM(subtotal) as total_revenue')
                    ->groupBy('menu_item_id')
                    ->orderByDesc('total_qty')
                    ->take(5)->get();

        // Hourly breakdown
        $hourly = [];
        for ($h = 0; $h < 24; $h++) {
            $hourly[$h] = $orders->filter(function($o) use ($h) {
                return $o->created_at->hour === $h;
            })->count();
        }

        return view('admin.reports.daily',
            compact('summary', 'orders', 'topItems', 'hourly'));
    }
}