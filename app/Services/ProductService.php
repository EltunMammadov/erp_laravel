<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductService
{
    public function __construct(
        private ProductRepository $productRepository
    ){}

    public function list(Request $request)
    {
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'desc');
        $limit = $request->input('limit', 10);

        return $this->productRepository->list($sort, $order, $limit);
    }

    public function create(Request $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;

        return $this->productRepository->create($data);
    }

    public function read(int $product_id)
    {
        return $this->productRepository->read($product_id);
    }

    public function update(Request $request, int $product_id)
    {
        return $this->productRepository->update($request->validated(), $product_id);
    }

    public function delete(int $product_id)
    {
        return $this->productRepository->delete($product_id);
    }
}