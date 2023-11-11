<?php

namespace App\Services\TransactionItem;

use App\Models\TransactionItem;

interface ITransactionItemService {
    public function all(): array;
    public function findById($id): ?TransactionItem;
    public function create(array $data): TransactionItem;
}
