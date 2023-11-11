<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Services\Customer\ICustomerService;
use App\Services\Product\IProductService;
use App\Services\Transaction\ITransactionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransactionsController extends Controller
{
    protected $transService;
    protected $customerService;
    protected $productService;

    public function __construct(ITransactionService $transService, ICustomerService $customerService, IProductService $productService)
    {
        $this->transService = $transService;
        $this->customerService = $customerService;
        $this->productService = $productService;
    }

    public function all() {
        try {
            $trans = $this->transService->all();

            return response()
            ->json([
                    "message" => "All Transactions!",
                    "result" => $trans
                ])
            ->setStatusCode(Response::HTTP_OK);
        } catch (\Exception $ex) {
            // Log error
        }

        return response()->json([
            "message" => "Application error. Please try again.",
            "result" => null
        ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function save(OrderRequest $req) {
        $validatedData = $req->validated();

        try {

            $customer = $this->customerService->findByPhone($req['customer_phone']);

            if(!$customer) {
                $customer = $this->customerService->create([
                    'phone' => $req['customer_phone'],
                    'name' => $req['customer_name'],
                    'address' => $req['customer_address'],
                ]);
            }

            $trans = $this->transService->create([
                'user_id' => $req->user()->id,
                'customer_id' => $customer->id,
            ]);

            $transCost = 0;
            $itemsData = [];

            foreach ($validatedData['items'] as $item) {
                $product = $this->productService->findById($item['product_id']);
                $amt = $item['quantity'] * $product->selling_price;

                $itemsData[] = [
                    'transaction_id' => $trans->id,
                    'product_id' => $product->id,
                    'unit_price' => $product->selling_price,
                    'quantity' => $item['quantity'],
                    'amount' => $amt,
                    'description' => $product->name,
                ];

                $transCost += $amt;
            }

            $this->transService->saveItems($itemsData);
            $trans->update([
                'total_amount' => $transCost,
                'invoice_number' => $this->generateInvoiceNumber($trans->id),
            ]);

            $trans->fresh();

            return response()
            ->json([
                "message" => "Transaction Saved!",
                "result" => $trans->load('transactionItems')
            ])
            ->setStatusCode(Response::HTTP_OK);
        } catch (\Exception $ex) {
            // Log error
        }

        return response()->json([
            "message" => "Application error. Please try again.",
            "result" => null
        ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function getInvoice(string $invoiceNumber) {
        try {
            $trans = $this->transService->findByInvoiceNumber($invoiceNumber);

        if(!$trans) {
            return response()
            ->json(["message" => "Transaction not found!", "result" => null])
            ->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        return response()
            ->json(["message" => "Transaction found!", "result" => $trans])
            ->setStatusCode(Response::HTTP_OK);

        } catch (\Exception $ex) {
            // Log error
        }

        return response()->json([
            "message" => "Application error. Please try again.",
            "result" => null
        ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    private function generateInvoiceNumber($transactionID): string {
        $invNum = $transactionID;

        if(strlen((string) $invNum) < 6) {
            return str_pad($invNum, 6, '0', STR_PAD_LEFT);
        }
        return (string) $invNum;
    }
}
