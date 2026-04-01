<?php

namespace App\Services;

use App\Repositories\OrderItemRepository;
use Illuminate\Http\Request;

class OrderItemService
{
    public function __construct(
        private OrderItemRepository $orderItemRepository
    ){}

    public function list(Request $request, int $order_id)
    {
        $sort = $request->input('sort', 'id');
        $direction = $request->input('order', 'desc');
        $limit = $request->input('limit', 10);

        return $this->orderItemRepository->listByOrder($order_id, $sort, $direction, $limit);
    }

    public function create(Request $request, int $order_id)
    {
        $data = $request->validated();
        $data['order_id'] = $order_id;
        $data['line_total'] = $data['quantity'] * $data['unit_price'];

        return $this->orderItemRepository->create($data);
    }

    public function read(int $order_id, int $item_id)
    {
        return $this->orderItemRepository->read($order_id, $item_id);
    }

    public function update(Request $request, int $order_id, int $item_id)
    {
        $data = $request->validated();

        if (isset($data['quantity']) || isset($data['unit_price'])) {
            $existing = $this->orderItemRepository->read($order_id, $item_id);
            $quantity = $data['quantity'] ?? $existing->quantity;
            $unit_price = $data['unit_price'] ?? $existing->unit_price;
            $data['line_total'] = $quantity * $unit_price;
        }

        return $this->orderItemRepository->update($data, $order_id, $item_id);
    }

    public function delete(int $order_id, int $item_id)
    {
        return $this->orderItemRepository->delete($order_id, $item_id);
    }
}
