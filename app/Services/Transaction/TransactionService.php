<?php

namespace App\Services\Transaction;

use App\Models\Transaction;
use App\Models\TransactionItem;

class TransactionService implements ITransactionService{
    public function all(): array {
        return Transaction::all()->toArray();
    }

    public function allByUser($id): array {
        return Transaction::where('user_id', $id)->get()->toArray();
    }

    public function findById($id): ?Transaction{
        return Transaction::find($id);
    }
    public function findByInvoiceNumber($invoiceNumber): ?Transaction{
        return Transaction::where('invoice_number', $invoiceNumber)->first();
    }

    public function create(array $data): Transaction{
        return Transaction::create($data);
    }

    public function saveItems(array $data) {
        return TransactionItem::insert($data);
    }
}
