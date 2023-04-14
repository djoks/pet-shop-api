<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Resources\OrderStatusResource;

class OrderStatusController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->orderService->getStatuses(
            page: request()->query('page', 1),
            limit: request()->query('limit', 10),
            sortBy: request()->query('sortBy', 'id'),
            desc: request()->query('desc', false)
        );

        $statuses = OrderStatusResource::collection($data['data']);

        return response()->json([
            'data' => $statuses,
            'page' => (int) $data['page'],
            'limit' => (int) $data['limit'],
            'total' => $data['total'],
            'sort_by' => $data['sort_by'],
            'desc' => (bool) $data['desc'],
        ], 200);
    }
}
