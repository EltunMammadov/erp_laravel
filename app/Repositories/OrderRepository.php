<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository
{
    public function __construct(
        private Order $order
    ){}

    public function list($sort, $order, $limit)
    {
        return $this->order->select([
            'id',
            'order_number',
            'customer_id',
            'status',
            'order_date',
            'total_amount',
            'discount_pct',
            'net_amount',
            'notes',
            'assigned_to',
            'created_by',
            'created_at',
            'updated_at'
        ])->orderBy($sort, $order)->paginate($limit);
    }

    public function create(array $data)
    {
        return $this->order->create($data);
    }

    public function read(int $order_id)
    {
        return $this->order->select([
            'id',
            'order_number',
            'customer_id',
            'status',
            'order_date',
            'total_amount',
            'discount_pct',
            'net_amount',
            'notes',
            'assigned_to',
            'created_by',
            'created_at',
            'updated_at'
        ])->where('id', $order_id)->first();
    }

    public function update(array $data, int $order_id)
    {
        return $this->order
        ->where('id', $order_id)
        ->update($data);
    }

    public function delete(int $order_id)
    {
        return $this->order->where('id' ,$order_id)->delete();
    }

    public function countToday(): int
    {
        return $this->order->whereDate('created_at', today())->count();
    }
}