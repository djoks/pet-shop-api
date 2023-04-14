<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderStatus;

class OrderService
{
    protected \App\Services\TokenService $tokenService;

    public function __construct(\App\Services\TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @return App\Models\User|null
     */
    public function getByUuid(string $uuid)
    {
        $order = Order::where('uuid', $uuid)->first();
        if (!$order) {
            return (object) [
                'code' => 404,
                'message' => 'Order not found.',
            ];
        }

        return $order;
    }

    /**
     * @return array<App\Models\User>
     */
    public function getAll($page = 1, $limit = 10, $sortBy = 'id', $desc = false)
    {
        $query = Order::query();
        $query->with(['user', 'orderStatus', 'payment']);
        $query->orderBy($sortBy, $desc ? 'desc' : 'asc');
        $total = $query->count();
        $query->skip(($page - 1) * $limit)->take($limit);
        $users = $query->get();

        $response = [
            'data' => $users,
            'page' => (int) $page,
            'limit' => (int) $limit,
            'total' => $total,
            'sort_by' => $sortBy,
            'desc' => (bool) $desc,
        ];

        return $response;
    }

    /**
     * @return array<App\Models\OrderStatus>
     */
    public function getStatuses($page = 1, $limit = 10, $sortBy = 'id', $desc = false)
    {
        $query = OrderStatus::query();
        $query->orderBy($sortBy, $desc ? 'desc' : 'asc');
        $total = $query->count();
        $query->skip(($page - 1) * $limit)->take($limit);
        $statuses = $query->get();

        $response = [
            'data' => $statuses,
            'page' => (int) $page,
            'limit' => (int) $limit,
            'total' => $total,
            'sort_by' => $sortBy,
            'desc' => (bool) $desc,
        ];

        return $response;
    }

    public function update(string $orderUuid, string $statusUuid)
    {
        $order = $this->getByUuid($orderUuid);

        logger(['orderUuid' => $orderUuid, 'statusUuid' => $statusUuid, 'order' => $order]);

        if (!$order) {
            return (object) [
                'code' => 400,
                'message' => 'Order not found.',
            ];
        }

        $r = $order->update([
            'order_status_id' => $statusUuid,
        ]);

        logger(['r' => $r]);

        return (object) [
            'code' => 200,
            'message' => 'Order updated successfully.',
        ];
    }
}
