<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Table;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        // Categories
        $starters = Category::create([
            'name' => 'Starters',
            'is_active' => true
        ]);
        $main = Category::create([
            'name' => 'Main Course',
            'is_active' => true
        ]);
        $desserts = Category::create([
            'name' => 'Desserts',
            'is_active' => true
        ]);
        $drinks = Category::create([
            'name' => 'Drinks',
            'is_active' => true
        ]);

        // Menu Items
        MenuItem::create([
            'category_id'  => $starters->id,
            'name'         => 'Chicken Soup',
            'description'  => 'Hot and spicy chicken soup with herbs',
            'price'        => 350,
            'is_available' => true,
            'is_featured'  => true,
        ]);
        MenuItem::create([
            'category_id'  => $starters->id,
            'name'         => 'Spring Rolls',
            'description'  => 'Crispy vegetable spring rolls with sauce',
            'price'        => 280,
            'is_available' => true,
            'is_featured'  => false,
        ]);
        MenuItem::create([
            'category_id'  => $main->id,
            'name'         => 'Grilled Chicken',
            'description'  => 'Tender grilled chicken with BBQ sauce',
            'price'        => 850,
            'is_available' => true,
            'is_featured'  => true,
        ]);
        MenuItem::create([
            'category_id'  => $main->id,
            'name'         => 'Mutton Karahi',
            'description'  => 'Traditional mutton karahi with naan',
            'price'        => 1200,
            'is_available' => true,
            'is_featured'  => true,
        ]);
        MenuItem::create([
            'category_id'  => $main->id,
            'name'         => 'Beef Steak',
            'description'  => 'Juicy beef steak with mashed potatoes',
            'price'        => 1500,
            'is_available' => true,
            'is_featured'  => true,
        ]);
        MenuItem::create([
            'category_id'  => $desserts->id,
            'name'         => 'Chocolate Cake',
            'description'  => 'Rich chocolate cake with cream',
            'price'        => 450,
            'is_available' => true,
            'is_featured'  => true,
        ]);
        MenuItem::create([
            'category_id'  => $drinks->id,
            'name'         => 'Fresh Juice',
            'description'  => 'Seasonal fresh fruit juice',
            'price'        => 200,
            'is_available' => true,
            'is_featured'  => false,
        ]);
        MenuItem::create([
            'category_id'  => $drinks->id,
            'name'         => 'Mint Lemonade',
            'description'  => 'Refreshing mint lemonade',
            'price'        => 180,
            'is_available' => true,
            'is_featured'  => false,
        ]);

        // Tables
        Table::create(['table_number' => 1, 'capacity' => 2, 'status' => 'available']);
        Table::create(['table_number' => 2, 'capacity' => 4, 'status' => 'available']);
        Table::create(['table_number' => 3, 'capacity' => 4, 'status' => 'available']);
        Table::create(['table_number' => 4, 'capacity' => 6, 'status' => 'available']);
        Table::create(['table_number' => 5, 'capacity' => 6, 'status' => 'available']);
        Table::create(['table_number' => 6, 'capacity' => 8, 'status' => 'available']);
        Table::create(['table_number' => 7, 'capacity' => 2, 'status' => 'available']);
        Table::create(['table_number' => 8, 'capacity' => 4, 'status' => 'available']);
    }
}