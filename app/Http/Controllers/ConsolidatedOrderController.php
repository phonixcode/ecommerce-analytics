<?php

namespace App\Http\Controllers;

use App\Services\ConsolidatedOrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConsolidatedOrderController extends Controller
{
    protected ConsolidatedOrderService $consolidatedOrderService;

    public function __construct(ConsolidatedOrderService $consolidatedOrderService)
    {
        $this->consolidatedOrderService = $consolidatedOrderService;
    }

    public function index(): JsonResponse
    {
        $orders = $this->consolidatedOrderService->getAllOrders();
        return response()->json($orders);
    }

    public function show(int $id): JsonResponse
    {
        $order = $this->consolidatedOrderService->getOrderById($id);
        return $order
            ? response()->json($order)
            : response()->json(['message' => 'Order not found'], 404);
    }

    public function export()
    {
        return $this->consolidatedOrderService->exportOrders();
    }

    public function refresh()
    {
        $this->consolidatedOrderService->refreshConsolidatedOrders();
        return response()->json(['message' => 'Consolidated orders refreshed successfully']);
    }
}
