<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\ConsolidatedOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ConsolidatedOrder>
 */
class ConsolidatedOrderFactory extends Factory
{
    protected $model = ConsolidatedOrder::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customer = Customer::factory()->create();
        $order = Order::factory()->create(['customer_id' => $customer->id]);
        $product = Product::factory()->create();
        $quantity = $this->faker->numberBetween(1, 5);
        $price = $product->price;

        return [
            'order_id'      => $order->id,
            'customer_id'   => $customer->id,
            'customer_name' => $customer->name,
            'customer_email' => $customer->email,
            'product_id'    => $product->id,
            'product_name'  => $product->name,
            'sku'           => $product->sku,
            'quantity'      => $quantity,
            'item_price'    => $price,
            'line_total'    => $quantity * $price,
            'order_date'    => $order->order_date,
            'order_status'  => $order->order_status,
            'order_total'   => $order->order_total,
        ];
    }
}
