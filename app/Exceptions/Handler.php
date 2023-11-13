<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(['message' => 'Method Not Allowed',  'result' => null], Response::HTTP_METHOD_NOT_ALLOWED);
        }

        if ($exception instanceof UnauthorizedException || $exception->getStatusCode() == 403) {
            return response()->json(['message' => 'You are not authorized to make this request', 'result' => null], Response::HTTP_UNAUTHORIZED);
        }

        return parent::render($request, $exception);
    }
}
