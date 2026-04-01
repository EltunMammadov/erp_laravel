<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CreateCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Resources\Customer\CustomerResource;
use App\Http\Resources\MetaResource;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct(
        private CustomerService $customerService
    ){}

    public function index(Request $request)
    {
        $items = $this->customerService->list($request);

        return response()->json([
            'data' => [
                'meta' => new MetaResource($items),
                'items' => CustomerResource::collection($items)
            ]
        ], 200);
    }

    public function create(CreateCustomerRequest $request)
    {
        $customer = $this->customerService->create($request);
        
        if (!$customer) {
            return response([
                'success' => false,
                'message' => 'Bad Request'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => [
                'item' => new CustomerResource($customer)
            ]
        ], 201);
    }

    public function read(int $product_id)
    {
        $item = $this->customerService->read($product_id);

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => [
                'item' => new CustomerResource($item)
            ]
        ], 200);
    }

    public function update(UpdateCustomerRequest $request, int $product_id)
    {
        $this->customerService->update($request, $product_id);
        $item = $this->customerService->read($product_id);

        return response()->json([
            'success' => true,
            'message' => 'Updated',
            'data' => [
                'item' => new CustomerResource($item)
            ]
        ],200);
    }

    public function delete(int $product_id)
    {
        $this->customerService->delete($product_id);

        return response()->json([
            'success' => true,
            'message' => 'Deleted'
        ], 200);
    }
}
