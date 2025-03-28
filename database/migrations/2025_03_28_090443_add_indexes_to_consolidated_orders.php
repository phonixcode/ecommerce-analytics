<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('consolidated_orders', function (Blueprint $table) {
            $table->index('order_id');
            $table->index('customer_id');
            $table->index('product_id');
            $table->index('sku');
            $table->index('order_date');
            $table->index('order_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consolidated_orders', function (Blueprint $table) {
            $table->dropIndex(['order_id']);
            $table->dropIndex(['customer_id']);
            $table->dropIndex(['product_id']);
            $table->dropIndex(['sku']);
            $table->dropIndex(['order_date']);
            $table->dropIndex(['order_status']);
        });
    }
};
