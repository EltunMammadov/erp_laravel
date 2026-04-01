<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class OrderService
{
    public function __construct(
        private OrderRepository $orderRepository
    ){}

    public function list(Request $request)
    {
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'desc');
        $limit = $request->input('limit', 10);

        return $this->orderRepository->list($sort, $order, $limit);
    }

    public function create(Request $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['order_number'] = $this->generateOrderNumber();

        return $this->orderRepository->create($data);
    }

    private function generateOrderNumber(): string
    {
        $date = now()->format('Ymd');
        $sequence = $this->orderRepository->countToday() + 1;

        return 'ORD-' . $date . '-' . str_pad($sequence, 5, '0', STR_PAD_LEFT);
    }

    public function read(int $order_id)
    {
        return $this->orderRepository->read($order_id);
    }

    public function update(Request $request, int $order_id)
    {
        return $this->orderRepository->update($request->validated(), $order_id);
    }

    public function delete(int $order_id)
    {
        return $this->orderRepository->delete($order_id);
    }
}