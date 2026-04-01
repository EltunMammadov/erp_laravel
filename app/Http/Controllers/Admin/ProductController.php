<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\MetaResource;
use App\Http\Resources\Prouduct\ProductResource;
use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService
    ){}

    public function index(Request $request)
    {
        $items = $this->productService->list($request);

        return response()->json([
            'data' => [
                'meta' => new MetaResource($items),
                'items' => ProductResource::collection($items)
            ]
        ], 200);
    }

    public function create(CreateProductRequest $request)
    {
        $product = $this->productService->create($request);
        
        if (!$product) {
            return response([
                'success' => false,
                'message' => 'Bad Request'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => [
                'item' => new ProductResource($product)
            ]
        ], 201);
    }

    public function read(int $product_id)
    {
        $item = $this->productService->read($product_id);

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => [
                'item' => new ProductResource($item)
            ]
        ], 200);
    }

    public function update(UpdateProductRequest $request, int $product_id)
    {
        $this->productService->update($request, $product_id);
        $item = $this->productService->read($product_id);

        return response()->json([
            'success' => true,
            'message' => 'Updated',
            'data' => [
                'item' => new ProductResource($item)
            ]
        ],200);
    }

    public function delete(int $product_id)
    {
        $this->productService->delete($product_id);

        return response()->json([
            'success' => true,
            'message' => 'Deleted'
        ], 200);
    }
}
