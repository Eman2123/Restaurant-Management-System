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
            'code'        => 'required|string|unique:coupons,code|max:20',
            'description' => 'nullable|string|max:255',
            'type'        => 'required|in:percentage,fixed',
            'value'       => 'required|numeric|min:1',
            'min_order'   => 'nullable|numeric|min:0',
            'max_uses'    => 'nullable|integer|min:1',
            'expires_at'  => 'nullable|date|after:today',
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
               ->with('success', 'Coupon created!');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return back()->with('success', 'Coupon deleted!');
    }

    public function toggle(Coupon $coupon)
    {
        $coupon->update(['is_active' => !$coupon->is_active]);
        return back()->with('success', 'Coupon updated!');
    }
}