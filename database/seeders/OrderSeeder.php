<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use App\Models\Table;
use App\Models\User;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $user  = User::where('role', 'customer')->first()
                 ?? User::first();
        $items = MenuItem::all();
        $tables = Table::all();

        if ($items->isEmpty() || $tables->isEmpty()) {
            $this->command->warn('No menu items or tables found. Run RestaurantSeeder first.');
            return;
        }

        // Order 1 — Pending
        $order1 = Order::create([
            'user_id'        => $user->id,
            'table_id'       => $tables[0]->id,
            'order_type'     => 'dine_in',
            'status'         => 'pending',
            'payment_status' => 'unpaid',
            'payment_method' => 'cash',
            'total_amount'   => 0,
            'notes'          => 'Less spicy please',
        ]);
        $total = 0;
        $item1 = $items[0];
        $item2 = $items[2];
        OrderItem::create([
            'order_id'    => $order1->id,
            'menu_item_id'=> $item1->id,
            'quantity'    => 2,
            'unit_price'  => $item1->price,
            'subtotal'    => $item1->price * 2,
        ]);
        $total += $item1->price * 2;
        OrderItem::create([
            'order_id'    => $order1->id,
            'menu_item_id'=> $item2->id,
            'quantity'    => 1,
            'unit_price'  => $item2->price,
            'subtotal'    => $item2->price,
        ]);
        $total += $item2->price;
        $order1->update(['total_amount' => $total]);

        // Order 2 — Cooking
        $order2 = Order::create([
            'user_id'        => $user->id,
            'table_id'       => $tables[1]->id,
            'order_type'     => 'dine_in',
            'status'         => 'cooking',
            'payment_status' => 'unpaid',
            'payment_method' => 'card',
            'total_amount'   => 0,
        ]);
        $total2 = 0;
        $item3 = $items[3];
        OrderItem::create([
            'order_id'    => $order2->id,
            'menu_item_id'=> $item3->id,
            'quantity'    => 1,
            'unit_price'  => $item3->price,
            'subtotal'    => $item3->price,
            'special_instructions' => 'Extra sauce',
        ]);
        $total2 += $item3->price;
        $order2->update(['total_amount' => $total2]);

        // Order 3 — Served + Paid
        $order3 = Order::create([
            'user_id'        => $user->id,
            'table_id'       => $tables[2]->id,
            'order_type'     => 'dine_in',
            'status'         => 'served',
            'payment_status' => 'paid',
            'payment_method' => 'cash',
            'total_amount'   => 0,
        ]);
        $total3 = 0;
        $item4 = $items->last();
        OrderItem::create([
            'order_id'    => $order3->id,
            'menu_item_id'=> $item4->id,
            'quantity'    => 3,
            'unit_price'  => $item4->price,
            'subtotal'    => $item4->price * 3,
        ]);
        $total3 += $item4->price * 3;
        $order3->update(['total_amount' => $total3]);

        $this->command->info('Orders seeded successfully!');
    }
}