<?php

namespace App\Services\Customer;

use App\Models\Customer;

interface ICustomerService {
    public function all(): array;
    public function findById($id): ?Customer;
    public function findByPhone($phoneNumber): ?Customer;
    public function create(array $data): Customer;
}
