<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->get();

        $query = MenuItem::where('is_available', true)
                         ->with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('description', 'like',
                            '%'.$request->search.'%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('sort')) {
            if ($request->sort === 'price_low') {
                $query->orderBy('price', 'asc');
            } elseif ($request->sort === 'price_high') {
                $query->orderBy('price', 'desc');
            } elseif ($request->sort === 'name') {
                $query->orderBy('name', 'asc');
            }
        }

        $menuItems = $query->get();

        return view('customer.menu',
                    compact('menuItems', 'categories'));
    }

    public function show(MenuItem $menuItem)
    {
        $related = MenuItem::where('category_id',
                                   $menuItem->category_id)
                            ->where('id', '!=', $menuItem->id)
                            ->where('is_available', true)
                            ->take(3)->get();

        return view('customer.menu-show',
                    compact('menuItem', 'related'));
    }
}