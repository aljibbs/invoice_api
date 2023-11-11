<?php

namespace App\Services\Customer;

use App\Models\Customer;

class CustomerService implements ICustomerService{
    public function all(): array {
        return Customer::all()->toArray();
    }

    public function findById($id): ?Customer{
        return Customer::find($id);
    }

    public function findByPhone($phoneNumber): ?Customer{
        return Customer::where('phone_number', $phoneNumber)->first();
    }

    public function create(array $data): Customer{
        return Customer::create($data);
    }
}
