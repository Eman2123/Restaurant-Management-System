<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'       => 'required|string|max:20|unique:coupons,code',
            'type'       => 'required|in:percentage,fixed',
            'value'      => 'required|numeric|min:1',
            'min_order'  => 'nullable|numeric|min:0',
            'max_uses'   => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        Coupon::create([
            'code'        => strtoupper($request->code),
            'description' => $request->description,
            'type'        => $request->type,
            'value'       => $request->value,
            'min_order'   => $request->min_order ?? 0,
            'max_uses'    => $request->max_uses,
            'expires_at'  => $request->expires_at,
            'is_active'   => true,
        ]);

        return redirect()->route('admin.coupons.index')
               ->with('success', 'Coupon created successfully!');
    }

    public function show(Coupon $coupon)
    {
        return redirect()->route('admin.coupons.index');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code'       => 'required|string|max:20|unique:coupons,code,'.$coupon->id,
            'type'       => 'required|in:percentage,fixed',
            'value'      => 'required|numeric|min:1',
            'min_order'  => 'nullable|numeric|min:0',
            'max_uses'   => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        $coupon->update([
            'code'        => strtoupper($request->code),
            'description' => $request->description,
            'type'        => $request->type,
            'value'       => $request->value,
            'min_order'   => $request->min_order ?? 0,
            'max_uses'    => $request->max_uses,
            'expires_at'  => $request->expires_at,
        ]);

        return redirect()->route('admin.coupons.index')
               ->with('success', 'Coupon updated!');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')
               ->with('success', 'Coupon deleted!');
    }

    public function toggle(Coupon $coupon)
    {
        $coupon->update(['is_active' => !$coupon->is_active]);
        return back()->with('success', 'Coupon status updated!');
    }
}