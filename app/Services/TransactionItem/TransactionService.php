<?php

namespace App\Services\TransactionItem;

use App\Models\TransactionItem;

class TransactionItemService implements ITransactionItemService {
    public function all(): array{
        return TransactionItem::all()->toArray();
    }

    public function findById($id): ?TransactionItem{
        return TransactionItem::find($id);
    }

    public function create(array $data): TransactionItem{
        return TransactionItem::create($data);
    }
}
