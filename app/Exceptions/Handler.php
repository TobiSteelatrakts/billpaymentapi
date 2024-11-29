<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

use Exception;
class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */


    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {

        if($request->expectsJson()) {

            switch(true) {
                case $exception instanceof ModelNotFoundException:
                    return response()->json([
                        'error' => 'Record does not exist',
                    ], 404);
                    break;
                case $exception instanceof NotFoundHttpException:
                    return response()->json([
                        'error' => 'route not found',
                    ], 400);

                case $exception instanceof MethodNotAllowedHttpException :
                return response()->json([
                        'error' => 'method not allowed',
                    ], 400);
                    break;

                case $exception instanceof AuthenticationException:
                        return response()->json([
                                'error' => 'Unauthenticated. Please login',
                            ], 400);
                            break;
                default:
                    return response()->json([
                            'error' => $exception->getMessage(),
                        ], 400);
                    break;

            }
        }


        return parent::render($request, $exception);
    }


    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated'], 401);

        }

        return parent::render($request, $exception);
    }
         public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
