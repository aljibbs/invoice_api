<?php

namespace App\Services\Transaction;

use App\Models\Transaction;

interface ITransactionService {
    public function all(): array;
    public function findById($id): ?Transaction;
    public function findByInvoiceNumber($invoiceNumber): ?Transaction;
    public function create(array $data): Transaction;
    // public function update($id, array $data);
    // public function delete($id);
}
