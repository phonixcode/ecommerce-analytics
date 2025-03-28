<?php

namespace App\Repositories;

use App\Models\ConsolidatedOrder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ConsolidatedOrderRepository
{
    public function getAll()
    {
        return ConsolidatedOrder::latest()->paginate(20);
    }

    public function findById(int $id)
    {
        return ConsolidatedOrder::find($id);
    }

    public function exportQuery()
    {
        return ConsolidatedOrder::select([
            'order_id', 'customer_id', 'customer_name', 'customer_email',
            'product_id', 'product_name', 'sku', 'quantity', 'item_price',
            'line_total', 'order_date', 'order_status', 'order_total'
        ]);
    }

    public function truncateTable()
    {
        ConsolidatedOrder::truncate();
    }

    public function insertOrders($orders)
    {
        DB::transaction(function () use ($orders) {
            $newRecords = [];

            foreach ($orders as $order) {
                foreach ($order->orderItems as $item) {
                    $newRecords[] = [
                        'order_id'       => $order->id,
                        'customer_id'    => $order->customer->id,
                        'customer_name'  => $order->customer->name,
                        'customer_email' => $order->customer->email,
                        'product_id'     => $item->product->id,
                        'product_name'   => $item->product->name,
                        'sku'            => $item->product->sku,
                        'quantity'       => $item->quantity,
                        'item_price'     => $item->price,
                        'line_total'     => $item->quantity * $item->price,
                        'order_date'     => $order->order_date,
                        'order_status'   => $order->status,
                        'order_total'    => $order->total_amount,
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ];
                }
            }

            if (!empty($newRecords)) {
                foreach (array_chunk($newRecords, 1000) as $chunk) {
                    ConsolidatedOrder::insert($chunk);
                }
            }
        });
    }
}
