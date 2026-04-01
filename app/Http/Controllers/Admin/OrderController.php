<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\MetaResource;
use App\Http\Resources\Order\OrderResource;
use Illuminate\Http\Request;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ){}

    public function index(Request $request)
    {
        $items = $this->orderService->list($request);

        return response()->json([
            'data' => [
                'meta' => new MetaResource($items),
                'items' => OrderResource::collection($items)
            ]
        ], 200);
    }

    public function create(CreateOrderRequest $request)
    {
        $order = $this->orderService->create($request);
        
        if (!$order) {
            return response([
                'success' => false,
                'message' => 'Bad Request'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => [
                'item' => new OrderResource($order)
            ]
        ], 201);
    }

    public function read(int $order_id)
    {
        $item = $this->orderService->read($order_id);

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => [
                'item' => new OrderResource($item)
            ]
        ], 200);
    }

    public function update(UpdateOrderRequest $request, int $order_id)
    {
        $this->orderService->update($request, $order_id);
        $item = $this->orderService->read($order_id);

        return response()->json([
            'success' => true,
            'message' => 'Updated',
            'data' => [
                'item' => new OrderResource($item)
            ]
        ],200);
    }

    public function delete(int $order_id)
    {
        $this->orderService->delete($order_id);

        return response()->json([
            'success' => true,
            'message' => 'Deleted'
        ], 200);
    }
}
