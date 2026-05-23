<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Table;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Reservation;
use App\Models\Coupon;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;

class FinalSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ──────────────────────────────────────────
        $admin = User::firstOrCreate(
            ['email' => 'admin@rms.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('password'),
                'role'     => 'admin',
                'phone'    => '+92 300 1111111',
            ]
        );

        $staff = User::firstOrCreate(
            ['email' => 'staff@rms.com'],
            [
                'name'     => 'Chef Ali',
                'password' => Hash::make('password'),
                'role'     => 'staff',
                'phone'    => '+92 300 2222222',
            ]
        );

        $customer = User::firstOrCreate(
            ['email' => 'customer@rms.com'],
            [
                'name'     => 'Sara Ahmed',
                'password' => Hash::make('password'),
                'role'     => 'customer',
                'phone'    => '+92 300 3333333',
            ]
        );

        $this->command->info('Users created!');

        // ── Categories ─────────────────────────────────────
        $cats = [
            ['name' => 'Starters',    'is_active' => true],
            ['name' => 'Main Course', 'is_active' => true],
            ['name' => 'Desserts',    'is_active' => true],
            ['name' => 'Drinks',      'is_active' => true],
            ['name' => 'BBQ',         'is_active' => true],
        ];

        $catModels = [];
        foreach ($cats as $cat) {
            $catModels[] = Category::firstOrCreate(
                ['name' => $cat['name']],
                $cat
            );
        }

        $this->command->info('Categories created!');

        // ── Menu Items ─────────────────────────────────────
        $items = [
            // Starters
            ['category_id' => $catModels[0]->id, 'name' => 'Chicken Soup',
             'description' => 'Hot and spicy chicken soup with herbs',
             'price' => 350, 'is_featured' => true],
            ['category_id' => $catModels[0]->id, 'name' => 'Spring Rolls',
             'description' => 'Crispy vegetable spring rolls',
             'price' => 280, 'is_featured' => false],
            ['category_id' => $catModels[0]->id, 'name' => 'Garlic Bread',
             'description' => 'Toasted bread with garlic butter',
             'price' => 200, 'is_featured' => false],

            // Main Course
            ['category_id' => $catModels[1]->id, 'name' => 'Grilled Chicken',
             'description' => 'Tender grilled chicken with BBQ sauce',
             'price' => 850, 'is_featured' => true],
            ['category_id' => $catModels[1]->id, 'name' => 'Mutton Karahi',
             'description' => 'Traditional mutton karahi with naan',
             'price' => 1200, 'is_featured' => true],
            ['category_id' => $catModels[1]->id, 'name' => 'Beef Steak',
             'description' => 'Juicy beef steak with mashed potatoes',
             'price' => 1500, 'is_featured' => true],
            ['category_id' => $catModels[1]->id, 'name' => 'Chicken Biryani',
             'description' => 'Aromatic basmati rice with spiced chicken',
             'price' => 650, 'is_featured' => true],

            // Desserts
            ['category_id' => $catModels[2]->id, 'name' => 'Chocolate Cake',
             'description' => 'Rich chocolate cake with cream',
             'price' => 450, 'is_featured' => true],
            ['category_id' => $catModels[2]->id, 'name' => 'Gulab Jamun',
             'description' => 'Soft sweet dumplings in sugar syrup',
             'price' => 250, 'is_featured' => false],
            ['category_id' => $catModels[2]->id, 'name' => 'Ice Cream',
             'description' => 'Vanilla, chocolate or strawberry',
             'price' => 200, 'is_featured' => false],

            // Drinks
            ['category_id' => $catModels[3]->id, 'name' => 'Fresh Juice',
             'description' => 'Seasonal fresh fruit juice',
             'price' => 200, 'is_featured' => false],
            ['category_id' => $catModels[3]->id, 'name' => 'Mint Lemonade',
             'description' => 'Refreshing mint lemonade',
             'price' => 180, 'is_featured' => false],
            ['category_id' => $catModels[3]->id, 'name' => 'Soft Drink',
             'description' => 'Pepsi, 7UP, Sprite',
             'price' => 100, 'is_featured' => false],
            ['category_id' => $catModels[3]->id, 'name' => 'Lassi',
             'description' => 'Sweet or salty yogurt drink',
             'price' => 150, 'is_featured' => false],

            // BBQ
            ['category_id' => $catModels[4]->id, 'name' => 'Seekh Kebab',
             'description' => 'Minced meat kebabs on skewers',
             'price' => 600, 'is_featured' => true],
            ['category_id' => $catModels[4]->id, 'name' => 'Chicken Tikka',
             'description' => 'Marinated chicken pieces grilled to perfection',
             'price' => 750, 'is_featured' => false],
            ['category_id' => $catModels[4]->id, 'name' => 'Mix Grill',
             'description' => 'Assorted BBQ platter for 2',
             'price' => 1800, 'is_featured' => false],
        ];

        foreach ($items as $item) {
            MenuItem::firstOrCreate(
                ['name' => $item['name']],
                array_merge($item, ['is_available' => true])
            );
        }

        $this->command->info('Menu items created!');

        // ── Tables ─────────────────────────────────────────
        for ($i = 1; $i <= 10; $i++) {
            Table::firstOrCreate(
                ['table_number' => $i],
                [
                    'capacity' => $i <= 4 ? 2 :
                                  ($i <= 7 ? 4 :
                                  ($i <= 9 ? 6 : 8)),
                    'status' => 'available'
                ]
            );
        }

        $this->command->info('Tables created!');

        // ── Coupons ────────────────────────────────────────
        Coupon::firstOrCreate(
            ['code' => 'WELCOME20'],
            [
                'description' => '20% off for new customers',
                'type'        => 'percentage',
                'value'       => 20,
                'min_order'   => 500,
                'max_uses'    => 100,
                'is_active'   => true,
            ]
        );

        Coupon::firstOrCreate(
            ['code' => 'FLAT100'],
            [
                'description' => 'Rs.100 off on any order',
                'type'        => 'fixed',
                'value'       => 100,
                'min_order'   => 300,
                'is_active'   => true,
            ]
        );

        Coupon::firstOrCreate(
            ['code' => 'SAVE50'],
            [
                'description' => '50% off — limited time',
                'type'        => 'percentage',
                'value'       => 50,
                'min_order'   => 1000,
                'max_uses'    => 50,
                'expires_at'  => now()->addDays(30),
                'is_active'   => true,
            ]
        );

        $this->command->info('Coupons created!');

        // ── Settings ───────────────────────────────────────
        $settings = [
            'restaurant_name'    => 'The Venue Restaurant',
            'restaurant_email'   => 'info@thevenue.com',
            'restaurant_phone'   => '+92 300 1234567',
            'restaurant_address' => '123 Main Street, Karachi, Pakistan',
            'restaurant_hours'   => 'Daily: 12:00 PM - 11:00 PM',
            'currency'           => 'Rs.',
            'tax_percentage'     => '0',
            'min_order_amount'   => '200',
            'delivery_charges'   => '100',
            'facebook_url'       => 'https://facebook.com',
            'instagram_url'      => 'https://instagram.com',
            'twitter_url'        => 'https://twitter.com',
            'whatsapp_number'    => '+923001234567',
            'about_text'         => 'Experience fine dining at its best.',
            'maintenance_mode'   => '0',
            'allow_reservations' => '1',
            'allow_orders'       => '1',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }

        $this->command->info('Settings saved!');

        // ── Sample Orders ──────────────────────────────────
        $tables   = Table::all();
        $menuItems = MenuItem::all();

        if ($tables->count() && $menuItems->count()) {

            // Order 1 — Pending
            $order1 = Order::create([
                'user_id'        => $customer->id,
                'table_id'       => $tables[0]->id,
                'order_type'     => 'dine_in',
                'status'         => 'pending',
                'payment_status' => 'unpaid',
                'payment_method' => 'cash',
                'total_amount'   => 0,
                'notes'          => 'Less spicy please',
            ]);
            $t1 = 0;
            foreach ($menuItems->take(3) as $mi) {
                $qty = rand(1,2);
                $sub = $mi->price * $qty;
                $t1 += $sub;
                OrderItem::create([
                    'order_id'     => $order1->id,
                    'menu_item_id' => $mi->id,
                    'quantity'     => $qty,
                    'unit_price'   => $mi->price,
                    'subtotal'     => $sub,
                ]);
            }
            $order1->update(['total_amount' => $t1]);

            // Order 2 — Cooking
            $order2 = Order::create([
                'user_id'        => $customer->id,
                'table_id'       => $tables[1]->id,
                'order_type'     => 'dine_in',
                'status'         => 'cooking',
                'payment_status' => 'unpaid',
                'payment_method' => 'card',
                'total_amount'   => 0,
            ]);
            $t2 = 0;
            foreach ($menuItems->slice(3, 2) as $mi) {
                $sub = $mi->price * 1;
                $t2 += $sub;
                OrderItem::create([
                    'order_id'     => $order2->id,
                    'menu_item_id' => $mi->id,
                    'quantity'     => 1,
                    'unit_price'   => $mi->price,
                    'subtotal'     => $sub,
                ]);
            }
            $order2->update(['total_amount' => $t2]);

            // Order 3 — Served + Paid
            $order3 = Order::create([
                'user_id'        => $customer->id,
                'table_id'       => $tables[2]->id,
                'order_type'     => 'dine_in',
                'status'         => 'served',
                'payment_status' => 'paid',
                'payment_method' => 'cash',
                'total_amount'   => 0,
            ]);
            $t3 = 0;
            foreach ($menuItems->slice(5, 2) as $mi) {
                $sub = $mi->price * 2;
                $t3 += $sub;
                OrderItem::create([
                    'order_id'     => $order3->id,
                    'menu_item_id' => $mi->id,
                    'quantity'     => 2,
                    'unit_price'   => $mi->price,
                    'subtotal'     => $sub,
                ]);
            }
            $order3->update(['total_amount' => $t3]);

            // Order 4 — Takeaway
            $order4 = Order::create([
                'user_id'        => $customer->id,
                'table_id'       => null,
                'order_type'     => 'takeaway',
                'status'         => 'ready',
                'payment_status' => 'paid',
                'payment_method' => 'online',
                'total_amount'   => 0,
            ]);
            $t4 = 0;
            foreach ($menuItems->slice(7, 3) as $mi) {
                $sub = $mi->price * 1;
                $t4 += $sub;
                OrderItem::create([
                    'order_id'     => $order4->id,
                    'menu_item_id' => $mi->id,
                    'quantity'     => 1,
                    'unit_price'   => $mi->price,
                    'subtotal'     => $sub,
                ]);
            }
            $order4->update(['total_amount' => $t4]);

            $this->command->info('Sample orders created!');
        }

        // ── Sample Reservations ────────────────────────────
        if ($tables->count()) {
            Reservation::firstOrCreate(
                [
                    'user_id'  => $customer->id,
                    'table_id' => $tables[3]->id
                ],
                [
                    'guest_name'       => 'Sara Ahmed',
                    'guest_phone'      => '+92 300 3333333',
                    'guest_email'      => 'customer@rms.com',
                    'reservation_date' => now()->addDays(2)->toDateString(),
                    'reservation_time' => '19:00:00',
                    'guests_count'     => 4,
                    'status'           => 'confirmed',
                    'notes'            => 'Birthday celebration',
                ]
            );

            Reservation::firstOrCreate(
                [
                    'user_id'  => null,
                    'table_id' => $tables[4]->id,
                    'guest_phone' => '+92 300 9999999',
                ],
                [
                    'guest_name'       => 'Walk-in Guest',
                    'guest_phone'      => '+92 300 9999999',
                    'reservation_date' => now()->addDays(3)->toDateString(),
                    'reservation_time' => '20:00:00',
                    'guests_count'     => 2,
                    'status'           => 'pending',
                ]
            );

            $this->command->info('Reservations created!');
        }

        $this->command->info('');
        $this->command->info('=============================');
        $this->command->info('RMS Final Seeder Complete!');
        $this->command->info('=============================');
        $this->command->info('Admin:    admin@rms.com / password');
        $this->command->info('Staff:    staff@rms.com / password');
        $this->command->info('Customer: customer@rms.com / password');
        $this->command->info('Coupons:  WELCOME20 | FLAT100 | SAVE50');
        $this->command->info('=============================');
    }
}