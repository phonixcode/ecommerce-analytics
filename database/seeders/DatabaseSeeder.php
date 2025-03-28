<?php

namespace Database\Seeders;

use App\Models\ConsolidatedOrder;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Customer::factory(200)->create()->each(function ($customer) {
        //     $orders = Order::factory(10)->create(['customer_id' => $customer->id]);

        //     $orders->each(function ($order) {
        //         $products = Product::factory(5)->create();
        //         foreach ($products as $product) {
        //             OrderItem::factory()->create([
        //                 'order_id' => $order->id,
        //                 'product_id' => $product->id,
        //                 'price' => $product->price,
        //             ]);
        //         }
        //     });
        // });

        Customer::factory(200)->create()->each(function ($customer) {
            $orders = Order::factory(10)->create(['customer_id' => $customer->id]);

            $orders->each(function ($order) use ($customer) {
                $products = Product::factory(5)->create();

                foreach ($products as $product) {
                    $orderItem = OrderItem::factory()->create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => rand(1, 5),
                        'price' => $product->price,
                    ]);

                    // Insert into consolidated_orders table
                    ConsolidatedOrder::create([
                        'order_id'      => $order->id,
                        'customer_id'   => $customer->id,
                        'customer_name' => $customer->name,
                        'customer_email' => $customer->email,
                        'product_id'    => $product->id,
                        'product_name'  => $product->name,
                        'sku'           => $product->sku,
                        'quantity'      => $orderItem->quantity,
                        'item_price'    => $orderItem->price,
                        'line_total'    => $orderItem->quantity * $orderItem->price,
                        'order_date'    => $order->order_date,
                        'order_status'  => $order->status,
                        'order_total'   => $order->total_amount,
                    ]);
                }
            });
        });
    }
}
