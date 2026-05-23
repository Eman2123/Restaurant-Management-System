<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $featuredItems = MenuItem::where('is_featured', true)
                            ->where('is_available', true)
                            ->with('category')
                            ->take(6)->get();

        $categories = Category::where('is_active', true)->get();

        return view('customer.home', compact('featuredItems', 'categories'));
    }
}