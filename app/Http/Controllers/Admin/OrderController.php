<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Table;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user','table','orderItems'])
                    ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('payment')) {
            $query->where('payment_status', $request->payment);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->get();
        $stats  = [
            'total'   => Order::count(),
            'pending' => Order::where('status','pending')->count(),
            'cooking' => Order::where('status','cooking')->count(),
            'ready'   => Order::where('status','ready')->count(),
            'served'  => Order::where('status','served')->count(),
            'unpaid'  => Order::where('payment_status','unpaid')->count(),
        ];

        return view('admin.orders.index',
                    compact('orders','stats'));
    }

    public function create()
    {
        $tables    = Table::where('status', 'available')->get();
        $menuItems = MenuItem::where('is_available', true)
                             ->with('category')->get();
        return view('admin.orders.create',
                    compact('tables', 'menuItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_type'     => 'required',
            'items'          => 'required|array|min:1',
            'items.*.id'     => 'required|exists:menu_items,id',
            'items.*.qty'    => 'required|integer|min:1',
        ]);

        $total = 0;
        $order = Order::create([
            'user_id'        => auth()->id(),
            'table_id'       => $request->table_id,
            'order_type'     => $request->order_type,
            'status'         => 'pending',
            'payment_status' => 'unpaid',
            'payment_method' => $request->payment_method ?? 'cash',
            'total_amount'   => 0,
            'notes'          => $request->notes,
        ]);

        foreach ($request->items as $item) {
            $menuItem = MenuItem::find($item['id']);
            $subtotal = $menuItem->price * $item['qty'];
            $total   += $subtotal;

            $order->orderItems()->create([
                'menu_item_id'         => $menuItem->id,
                'quantity'             => $item['qty'],
                'unit_price'           => $menuItem->price,
                'subtotal'             => $subtotal,
                'special_instructions' => $item['note'] ?? null,
            ]);
        }

        $order->update(['total_amount' => $total]);

        return redirect()->route('admin.orders.show', $order)
               ->with('success', 'Order created successfully!');
    }

    public function show(Order $order)
    {
        $order->load(['user', 'table', 'orderItems.menuItem']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,cooking,ready,served,cancelled'
        ]);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Order status updated!');
    }

    public function updatePayment(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:paid,unpaid',
            'payment_method' => 'required|in:cash,card,online',
        ]);
        $order->update([
            'payment_status' => $request->payment_status,
            'payment_method' => $request->payment_method,
        ]);
        return back()->with('success', 'Payment updated!');
    }

    public function destroy(Order $order)
    {
        $order->orderItems()->delete();
        $order->delete();
        return redirect()->route('admin.orders.index')
               ->with('success', 'Order deleted!');
    }
    public function assignWaiter(Request $request, Order $order)
    {
        $request->validate([
            'waiter_id' => 'required|exists:users,id'
        ]);
        $order->update(['waiter_id' => $request->waiter_id]);
        return back()->with('success', 'Waiter assigned!');
    }
        
}