<?php

namespace App\Exports;

use App\Models\ConsolidatedOrder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Repositories\ConsolidatedOrderRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Exception;

class ConsolidatedOrdersExport implements FromQuery, WithHeadings, \Illuminate\Contracts\Queue\ShouldQueue, WithChunkReading
{
    use Exportable;

    protected ConsolidatedOrderRepository $repository;

    public function __construct(ConsolidatedOrderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get query for exporting data (optimized for large datasets)
     */
    public function query()
    {
        return $this->repository->exportQuery();
    }

    /**
     * Column headings for the exported file
     */
    public function headings(): array
    {
        return [
            'Order ID', 'Customer ID', 'Customer Name', 'Customer Email',
            'Product ID', 'Product Name', 'SKU', 'Quantity', 'Item Price',
            'Line Total', 'Order Date', 'Order Status', 'Order Total'
        ];
    }

    /**
     * Read data in chunks to prevent memory overload
     */
    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * Handle export failures
     */
    public function failed(Exception $exception)
    {
        Log::error('Export Failed: ' . $exception->getMessage());
    }
}

