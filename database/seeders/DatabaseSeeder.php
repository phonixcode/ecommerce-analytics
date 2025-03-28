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

        Customer::factory(200)->create()->each(function ($customer) {
            $orders = Order::factory(10)->create(['customer_id' => $customer->id]);

            $orders->each(function ($order) use ($customer) {
                $totalAmount = 0;

                $products = Product::factory(5)->create();

                foreach ($products as $product) {
                    $quantity = rand(1, 5);
                    $price = $product->price;
                    $lineTotal = $quantity * $price;

                    $totalAmount += $lineTotal;

                    $orderItem = OrderItem::factory()->create([
                        'order_id'   => $order->id,
                        'product_id' => $product->id,
                        'quantity'   => $quantity,
                        'price'      => $price,
                    ]);

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
                        'line_total'    => $lineTotal,
                        'order_date'    => $order->order_date,
                        'order_status'  => $order->status,
                        'order_total'   => $totalAmount,
                    ]);
                }

                $order->update(['total_amount' => $totalAmount]);
            });
        });
    }
}
