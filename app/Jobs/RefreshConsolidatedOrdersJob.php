<?php

namespace App\Jobs;

use App\Services\ConsolidatedOrderService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RefreshConsolidatedOrdersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ConsolidatedOrderService $consolidatedOrderService;

    /**
     * Create a new job instance.
     */
    public function __construct(ConsolidatedOrderService $consolidatedOrderService)
    {
        $this->consolidatedOrderService = $consolidatedOrderService;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $this->consolidatedOrderService->refreshConsolidatedOrders();
            Log::info('Consolidated orders refreshed successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to refresh consolidated orders: ' . $e->getMessage());
        }
    }
}
