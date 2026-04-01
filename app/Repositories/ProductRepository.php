<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function __construct(
        private Product $product
    ){}

    public function list($sort, $order, $limit)
    {
        return $this->product->select([
            'id',
            'name',
            'sku',
            'description',
            'category',
            'unit_price',
            'quantity_in_stock',
            'reorder_level',
            'is_active',
            'created_by',
            'created_at',
            'updated_at'
        ])->orderBy($sort, $order)->paginate($limit);
    }

    public function create(array $data)
    {
        return $this->product->create($data);
    }

    public function read(int $product_id)
    {
        return $this->product->select([
            'id',
            'name',
            'sku',
            'description',
            'category',
            'unit_price',
            'quantity_in_stock',
            'reorder_level',
            'is_active',
            'created_by',
            'created_at',
            'updated_at'
        ])->where('id', $product_id)->first();
    }

    public function update(array $data, int $product_id)
    {
        return $this->product
        ->where('id', $product_id)
        ->update($data);
    }

    public function delete(int $product_id)
    {
        return $this->product->where('id' ,$product_id)->delete();
    }
}