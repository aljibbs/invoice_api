<?php

namespace App\Services\Product;

use App\Models\Product;

class ProductService implements IProductService{
    public function all(): array {
        return Product::all()->toArray();
    }

    public function findById($id): ?Product{
        return Product::find($id);
    }

    public function create(array $data): Product{
        return Product::create($data);
    }

    public function update(Product $product, array $data){
        return $product->update($data);
    }
}
