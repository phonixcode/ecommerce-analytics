<?php

namespace App\Services;

use App\Repositories\ConsolidatedOrderRepository;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ConsolidatedOrdersExport;
use App\Models\Order;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ConsolidatedOrderService
{
    protected ConsolidatedOrderRepository $repository;

    public function __construct(ConsolidatedOrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllOrders()
    {
        return $this->repository->getAll();
    }

    public function getOrderById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function exportOrders()
    {
        try {
            return Excel::download(new ConsolidatedOrdersExport($this->repository), 'consolidated_orders.xlsx');
        } catch (Exception $e) {
            Log::error('Export Error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Export failed. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function refreshConsolidatedOrders()
    {
        $this->repository->truncateTable();

        Order::with(['customer', 'orderItems.product'])
        ->latest()
        ->chunk(500, function ($orders) {
            $this->repository->insertOrders($orders);
        });
    }
}
