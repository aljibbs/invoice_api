<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $req) {
        $validator = Validator::make($req->input(), [
            'name'    => 'required|string|max:255',
            'email'    => 'required|email',
            'password'  => 'required|confirmed',
        ]);

        if($validator->fails()) {
            return response()
            ->json(["message" => "All inputs required", "result" => null])
            ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $user = User::where('email', $req['email'])->first();

        if ($user) {
            return response()
            ->json([
                    "message" => "User account with email already exists!", "result" => null
                ])
            ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        try{
            $user = User::create([
                'name' => $req['name'],
                'email' => $req['email'],
                'password' => $req['password'],
            ]);

            $token = $user->createToken('user_auth_token')->plainTextToken;

            return response()
            ->json([
                'message' => "User account created",
                'result' => [
                    'grant' => $token,
                    'user' => $user,
                    ]
                ])
            ->setStatusCode(Response::HTTP_CREATED);
        } catch(\Exception $ex) {
            // Log error
        }

        return response()->json([
            "message" => "Application error. Please try again.",
            "result" => null
        ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);

    }

    public function login(Request $req) {
        $validator = Validator::make($req->input(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if($validator->fails()) {
            return response('All inputs required', Response::HTTP_BAD_REQUEST);
        }

        $user = User::where('email', $req['email'])->first();

        if (!$user || !Hash::check($req['password'], $user->password)) {
            return response()
            ->json([
                    "message" => "User account not found!", "result" => null
                ])
            ->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        try{
            $user->tokens()->delete();
            $token = $user->createToken('user_auth_token')->plainTextToken;

            return response()->json([
                'message' => "Login successful",
                'result' => [
                    'grant' => $token,
                    'user' => $user,
                ]
            ])->setStatusCode(200);
        } catch(\Exception $ex) {
            // Log error
        }

        return response()->json([
            "message" => "Application error. Please try again.",
            "result" => null
        ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function logout(Request $req) {
        $req->user()->tokens()->delete();
        return response()->json([
            "message" => "User successfully signed out",
            "result" => null
        ])->setStatusCode(Response::HTTP_OK);
    }
}
