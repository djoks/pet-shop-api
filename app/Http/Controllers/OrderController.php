<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
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
        $data = $this->orderService->getAll(
            page: request()->query('page', 1),
            limit: request()->query('limit', 10),
            sortBy: request()->query('sortBy', 'id'),
            desc: request()->query('desc', false)
        );

        $orders = OrderResource::collection($data['data']);

        return response()->json([
            'data' => $orders,
            'page' => (int) $data['page'],
            'limit' => (int) $data['limit'],
            'total' => $data['total'],
            'sort_by' => $data['sort_by'],
            'desc' => (bool) $data['desc'],
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid)
    {
        $response = $this->orderService->update(
            orderUuid: $uuid,
            statusUuid: $request->order_status_uuid
        );

        return response()->json($response->message, $response->code);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
