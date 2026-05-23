<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::with('category')->latest()->get();
        return view('admin.menu.index', compact('menuItems'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();

        // Debug — check if categories exist
        if($categories->isEmpty()) {
            // Categories table is empty — redirect to create category first
            return redirect()->route('admin.categories.create')
                ->with('error', 'Please create a category first!');
        }

        return view('admin.menu.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        $data = $request->only([
            'name','category_id','price',
            'description'
        ]);
        $data['is_available'] = $request->has('is_available');
        $data['is_featured']  = $request->has('is_featured');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                              ->store('menu', 'public');
        }

        MenuItem::create($data);

        return redirect()->route('admin.menu.index')
               ->with('success', 'Menu item added successfully!');
    }

    public function edit(MenuItem $menu)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.menu.edit',
                    compact('menu', 'categories'));
    }

    public function update(Request $request, MenuItem $menu)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'name','category_id','price','description'
        ]);
        $data['is_available'] = $request->has('is_available');
        $data['is_featured']  = $request->has('is_featured');

        if ($request->hasFile('image')) {
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            $data['image'] = $request->file('image')
                              ->store('menu', 'public');
        }

        $menu->update($data);

        return redirect()->route('admin.menu.index')
               ->with('success', 'Menu item updated!');
    }

    public function destroy(MenuItem $menu)
    {
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }
        $menu->delete();

        return redirect()->route('admin.menu.index')
               ->with('success', 'Menu item deleted!');
    }
}