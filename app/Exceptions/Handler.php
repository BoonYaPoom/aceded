<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
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
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
            $statusCode = $exception->getStatusCode();
            
            if ($statusCode == 500) {
                Log::error('Internal Server Error: ' . $exception->getMessage(), [
                    'exception' => $exception,
                    'request' => $request->all(), // บันทึกข้อมูล request ถ้าต้องการ
                ]);
                return response()->json([
                    'message' => Log::error($exception->getMessage()),
                ], 500);
            }
        }

        return parent::render($request, $exception);
    }
}
