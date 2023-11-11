<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\StockUpdateRequest;
use App\Services\Product\IProductService;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(IProductService $productService)
    {
        $this->productService = $productService;
    }

    public function all() {
        try {
            $prods = $this->productService->all();

            return response()
            ->json([
                    "message" => "All Products!",
                    "result" => $prods
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

    public function getProduct($id) {
        try {
            $product = $this->productService->findById($id);

            if(!$product) {
                return response()
                ->json(["message" => "Product not found!", "result" => null])
                ->setStatusCode(Response::HTTP_NOT_FOUND);
            }

            return response()
                ->json(["message" => "Product found!", "result" => $product])
                ->setStatusCode(Response::HTTP_OK);

        } catch (\Exception $ex) {
            // Log error
        }

        return response()->json([
            "message" => "Application error. Please try again.",
            "result" => null
        ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function save(ProductRequest $req){
        $validatedData = $req->validated();

        try{
            $product = $this->productService->create($validatedData);

            return response()->json([
                'message' => "Product Created",
                'result' => $product
            ])->setStatusCode(Response::HTTP_CREATED);
        } catch(\Exception $ex) {
            // Log error
        }

        return response()->json([
            "message" => "Application error. Please try again.",
            "result" => null
        ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function update(ProductRequest $req, $id){
        $validatedData = $req->validated();

        $product = $this->productService->findById($id);

        if(!$product) {
            return response()
            ->json(["message" => "Product not found!", "result" => null])
            ->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        try{
            $this->productService->update($product, $validatedData);
            $product->fresh();

            return response()->json([
                'message' => "Product Updated",
                'result' => $product
            ])->setStatusCode(Response::HTTP_OK);
        } catch(\Exception $ex) {
            // Log error
        }

        return response()->json([
            "message" => "Application error. Please try again.",
            "result" => null
        ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function addStock(StockUpdateRequest $req){
        $validatedData = $req->validated();

        try{
            $product = $this->productService->findById($validatedData['product_id']);

            if(!$product) {
                return response()
                ->json(["message" => "Product not found!", "result" => null])
                ->setStatusCode(Response::HTTP_NOT_FOUND);
            }

            $product->update([
                'quantity' => $product->quantity + $validatedData['quantity'],
            ]);
            $product->fresh();

            return response()->json([
                'message' => "New Stock Added",
                'result' => $product
            ])->setStatusCode(Response::HTTP_OK);
        } catch(\Exception $ex) {
            // Log error
        }

        return response()->json([
            "message" => "Application error. Please try again.",
            "result" => null
        ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
