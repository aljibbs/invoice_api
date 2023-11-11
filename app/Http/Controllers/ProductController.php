<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\Product\IProductService;
use Illuminate\Http\Request;
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

    public function save(){}
}
