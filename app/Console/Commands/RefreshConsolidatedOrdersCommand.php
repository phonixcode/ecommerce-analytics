<?php

namespace App\Console\Commands;

use App\Jobs\RefreshConsolidatedOrdersJob;
use App\Services\ConsolidatedOrderService;
use Illuminate\Console\Command;

class RefreshConsolidatedOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consolidated-orders:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Repopulate the consolidated_orders table with the latest data';

    protected ConsolidatedOrderService $consolidatedOrderService;

    public function __construct(ConsolidatedOrderService $consolidatedOrderService)
    {
        parent::__construct();
        $this->consolidatedOrderService = $consolidatedOrderService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dispatch(new RefreshConsolidatedOrdersJob($this->consolidatedOrderService));

        $this->info('Consolidated Orders refresh job dispatched successfully.');
    }
}
