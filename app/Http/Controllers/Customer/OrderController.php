<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\Category;
use App\Models\Table;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
                    ->with(['orderItems.menuItem', 'table'])
                    ->latest()->get();
        return view('customer.orders', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        $order->load(['orderItems.menuItem', 'table']);
        return view('customer.order-show', compact('order'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)
                        ->with(['menuItems' => function($q) {
                            $q->where('is_available', true);
                        }])->get();
        $tables = Table::where('status', 'available')->get();
        return view('customer.place-order',
                    compact('categories', 'tables'));
    }

    public function store(Request $request)
    {
        $filteredItems = [];
        if ($request->items) {
            foreach ($request->items as $key => $item) {
                if (!empty($item['id']) && !empty($item['qty'])
                    && (int)$item['qty'] > 0) {
                    $filteredItems[] = $item;
                }
            }
        }

        if (empty($filteredItems)) {
            return back()->withErrors([
                'items' => 'Please add at least one item!'
            ])->withInput();
        }

        $request->validate([
            'order_type' => 'required|in:dine_in,takeaway,delivery',
        ]);

        $total    = 0;
        $discount = 0;
        $couponCode = null;

        // Validate coupon if applied
        if ($request->filled('coupon_code')) {
            $coupon = \App\Models\Coupon::where('code',
                    strtoupper($request->coupon_code))
                    ->first();

            if ($coupon && $coupon->isValid()) {
                // Calculate total first to check min order
                foreach ($filteredItems as $item) {
                    $menuItem = MenuItem::find($item['id']);
                    if ($menuItem) {
                        $total += $menuItem->price * (int)$item['qty'];
                    }
                }

                if ($total >= $coupon->min_order) {
                    $discount   = $coupon->calculateDiscount($total);
                    $couponCode = $coupon->code;
                    $coupon->increment('used_count');
                }
                $total = 0; // Reset for recalculation below
            }
        }

        $order = Order::create([
            'user_id'         => auth()->id(),
            'table_id'        => $request->table_id ?? null,
            'order_type'      => $request->order_type,
            'status'          => 'pending',
            'payment_status'  => 'unpaid',
            'payment_method'  => $request->payment_method ?? 'cash',
            'total_amount'    => 0,
            'discount_amount' => $discount,
            'coupon_code'     => $couponCode,
            'notes'           => $request->notes,
        ]);

        foreach ($filteredItems as $item) {
            $menuItem = MenuItem::find($item['id']);
            if (!$menuItem) continue;
            $subtotal = $menuItem->price * (int)$item['qty'];
            $total   += $subtotal;
            $order->orderItems()->create([
                'menu_item_id'         => $menuItem->id,
                'quantity'             => (int)$item['qty'],
                'unit_price'           => $menuItem->price,
                'subtotal'             => $subtotal,
                'special_instructions' => $item['note'] ?? null,
            ]);
        }

        $finalTotal = max(0, $total - $discount);
        $order->update(['total_amount' => $finalTotal]);

        return redirect()->route('customer.orders.show', $order)
            ->with('success', 'Order placed successfully!');
    }
    public function applyCoupon(Request $request)
    {
        $coupon = \App\Models\Coupon::where('code',
                strtoupper($request->code))->first();

        if (!$coupon || !$coupon->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired coupon code.'
            ]);
        }

        if ($request->total < $coupon->min_order) {
            return response()->json([
                'success' => false,
                'message' => 'Minimum order Rs.'.
                            number_format($coupon->min_order, 0).
                            ' required for this coupon.'
            ]);
        }

        $discount = $coupon->calculateDiscount($request->total);

        return response()->json([
            'success'  => true,
            'discount' => $discount,
            'message'  => $coupon->type === 'percentage'
                        ? $coupon->value.'% off applied!'
                        : 'Rs.'.number_format($discount,0).' off applied!',
            'code'     => $coupon->code,
        ]);
    }
    }