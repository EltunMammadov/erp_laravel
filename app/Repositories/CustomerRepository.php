<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository
{
    public function __construct(
        private Customer $customer
    ){}

    public function list($sort, $order, $limit)
    {
        return $this->customer->select([
            'id',
            'name',
            'email',
            'phone',
            'address',
            'city',
            'country',
            'tax_id',
            'type',
            'is_active',
            'created_by',
            'created_at',
            'updated_at'
        ])->orderBy($sort, $order)->paginate($limit);
    }

    public function create(array $data)
    {
        return $this->customer->create($data);
    }

    public function read(int $customer_id)
    {
        return $this->customer->select([
            'id',
            'name',
            'email',
            'phone',
            'address',
            'city',
            'country',
            'tax_id',
            'type',
            'is_active',
            'created_by',
            'created_at',
            'updated_at'
        ])->where('id', $customer_id)->first();
    }

    public function update(array $data, int $customer_id)
    {
        return $this->customer
        ->where('id', $customer_id)
        ->update($data);
    }

    public function delete(int $customer_id)
    {
        return $this->customer->where('id' ,$customer_id)->delete();
    }
}