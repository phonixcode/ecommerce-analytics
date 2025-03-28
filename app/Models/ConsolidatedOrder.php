<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsolidatedOrder extends Model
{
    /** @use HasFactory<\Database\Factories\ConsolidatedOrderFactory> */
    use HasFactory;

    protected $fillable = [
        'order_id', 'customer_id', 'customer_name', 'customer_email',
        'product_id', 'product_name', 'sku', 'quantity', 'item_price',
        'line_total', 'order_date', 'order_status', 'order_total'
    ];
}
