<?php

namespace App\Repositories;

use App\Models\OrderItem;

class OrderItemRepository
{
    public function __construct(
        private OrderItem $orderItem
    ){}

    public function listByOrder(int $order_id, $sort, $direction, $limit)
    {
        return $this->orderItem->where('order_id', $order_id)
            ->select([
                'id',
                'order_id',
                'product_id',
                'quantity',
                'unit_price',
                'line_total'
            ])->orderBy($sort, $direction)->paginate($limit);
    }

    public function create(array $data)
    {
        return $this->orderItem->create($data);
    }

    public function read(int $order_id, int $orderItem_id)
    {
        return $this->orderItem->select([
            'id',
            'order_id',
            'product_id',
            'quantity',
            'unit_price',
            'line_total'
        ])->where('id', $orderItem_id)->where('order_id', $order_id)->first();
    }

    public function update(array $data, int $order_id, int $orderItem_id)
    {
        return $this->orderItem
            ->where('id', $orderItem_id)
            ->where('order_id', $order_id)
            ->update($data);
    }

    public function delete(int $order_id, int $orderItem_id)
    {
        return $this->orderItem
            ->where('id', $orderItem_id)
            ->where('order_id', $order_id)
            ->delete();
    }
}
