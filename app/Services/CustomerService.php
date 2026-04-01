<?php

namespace App\Services;

use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;

class CustomerService
{
    public function __construct(
        private CustomerRepository $customerRepository
    ){}

    public function list(Request $request)
    {
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'desc');
        $limit = $request->input('limit', 10);

        return $this->customerRepository->list($sort, $order, $limit);
    }

    public function create(Request $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;

        return $this->customerRepository->create($data);
    }

    public function read(int $customer_id)
    {
        return $this->customerRepository->read($customer_id);
    }

    public function update(Request $request, int $customer_id)
    {
        return $this->customerRepository->update($request->validated(), $customer_id);
    }

    public function delete(int $customer_id)
    {
        return $this->customerRepository->delete($customer_id);
    }
}