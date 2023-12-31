<?php

namespace App\Services\Product;

use App\Models\Product;

interface IProductService {
    public function all(): array;
    public function findById($id): ?Product;
    public function findAndLockById($id): ?Product;
    public function create(array $data): Product;
    public function update(Product $product, array $data);
}
