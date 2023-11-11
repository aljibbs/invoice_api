<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\Transaction\ITransactionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransactionsController extends Controller
{
    protected $svc;

    public function __construct(ITransactionService $transService)
    {
        $this->svc = $transService;
    }

    public function all() {
        try {
            $trans = $this->svc->all();

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

    public function save(Request $req) {
        try {

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
            $trans = $this->svc->findByInvoiceNumber($invoiceNumber);

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
}
