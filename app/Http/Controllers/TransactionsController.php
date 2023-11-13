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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            Log::error($ex);
        }

        return response()->json([
            "message" => "Application error. Please try again.",
            "result" => null
        ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function save(OrderRequest $req) {
        $validatedData = $req->validated();

        try {
            $customer = $this->customerService->findByPhone($validatedData['customer_phone']);

            if(!$customer) {
                $customer = $this->customerService->create([
                    'phone' => $validatedData['customer_phone'],
                    'name' => $validatedData['customer_name'],
                    'address' => $validatedData['customer_address'],
                ]);
            }


            DB::beginTransaction();

            $trans = $this->transService->create([
                'user_id' => auth()->user()->id,
                'customer_id' => $customer->id,
            ]);

            $transCost = 0;
            $itemsData = [];

            foreach ($validatedData['items'] as $item) {
                $productId = $item['product_id'];
                $quantity = (int) $item['quantity'];

                $product = $this->productService->findById($productId);

                if($quantity > $product->quantity) {
                    throw new \Exception("Quantity of {$product->name} is not sufficient. Only {$product->quantity} left");
                }

                $amt = $quantity * $product->selling_price;

                $itemsData[] = [
                    'transaction_id' => $trans->id,
                    'product_id' => $product->id,
                    'unit_price' => $product->selling_price,
                    'quantity' => $quantity,
                    'amount' => $amt,
                    'description' => $product->name,
                ];

                $transCost += $amt;

                $product->update([
                    'quantity' => $product->quantity - $quantity
                ]);

            }

            $this->transService->saveItems($itemsData);
            $trans->update([
                'total_amount' => $transCost,
                'invoice_number' => $this->generateInvoiceNumber($trans->id),
            ]);

            DB::commit();

            $trans->refresh();

            return response()
            ->json([
                "message" => "Transaction Saved!",
                "result" => $trans
            ])
            ->setStatusCode(Response::HTTP_CREATED);
        } catch (\Exception $ex) {
            // Log error
            DB::rollBack();
            Log::error($ex);

            return response()->json([
                "message" => $ex->getMessage(),
                "result" => null
            ])->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }


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
            Log::error($ex);
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
