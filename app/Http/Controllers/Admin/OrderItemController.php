<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderItem\CreateOrderItemRequest;
use App\Http\Requests\OrderItem\UpdateOrderItemRequest;
use App\Http\Resources\MetaResource;
use App\Http\Resources\OrderItem\OrderItemResource;
use App\Services\OrderItemService;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function __construct(
        private OrderItemService $orderItemService
    ){}

    public function index(Request $request, int $order_id)
    {
        $items = $this->orderItemService->list($request, $order_id);

        return response()->json([
            'data' => [
                'meta' => new MetaResource($items),
                'items' => OrderItemResource::collection($items)
            ]
        ], 200);
    }

    public function create(CreateOrderItemRequest $request, int $order_id)
    {
        $item = $this->orderItemService->create($request, $order_id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Bad Request'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => [
                'item' => new OrderItemResource($item)
            ]
        ], 201);
    }

    public function read(int $order_id, int $item_id)
    {
        $item = $this->orderItemService->read($order_id, $item_id);

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => [
                'item' => new OrderItemResource($item)
            ]
        ], 200);
    }

    public function update(UpdateOrderItemRequest $request, int $order_id, int $item_id)
    {
        $this->orderItemService->update($request, $order_id, $item_id);
        $item = $this->orderItemService->read($order_id, $item_id);

        return response()->json([
            'success' => true,
            'message' => 'Updated',
            'data' => [
                'item' => new OrderItemResource($item)
            ]
        ], 200);
    }

    public function delete(int $order_id, int $item_id)
    {
        $this->orderItemService->delete($order_id, $item_id);

        return response()->json([
            'success' => true,
            'message' => 'Deleted'
        ], 200);
    }
}
