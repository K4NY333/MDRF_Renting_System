<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $levels = [
        // Define custom log levels for exceptions
    ];

    protected $dontReport = [
        // Add exceptions that should not be reported
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($this->isHttpException($exception)) {
            $statusCode = $exception->getStatusCode();

            if (in_array($statusCode, [404, 419])) {
                return response()->view('errors.custom', [], $statusCode);
            }
        }

        return parent::render($request, $exception);
    }
}
