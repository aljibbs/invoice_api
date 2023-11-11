<?php

namespace App\Services\Transaction;

use App\Models\Transaction;

interface ITransactionService {
    public function all(): array;
    public function findById($id): ?Transaction;
    public function findByInvoiceNumber($id): ?Transaction;
    public function create(array $data): Transaction;
    public function saveItems(array $data);
}
