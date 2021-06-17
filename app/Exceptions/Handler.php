<?php

namespace App\Exceptions;

use Features\Core\Domain\Failure\ApiFailure;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (HttpException $e) {
            return jsonErrorResponse(
                $e->getStatusCode(),
                $e->getMessage(),
                'http_error'
            );
        });

        $this->renderable(function (ApiFailure $e) {
            return jsonErrorResponse(
                $e->getCode(),
                $e->getMessage(),
                $e->getError(),
            );
        });

        $this->renderable(function (ValidationException $e) {
            $errors = array_map(function ($error) {
                return $error[0];
            }, array_values($e->errors()));
            return jsonErrorResponse(
                $e->status,
                __('validation_error'),
                'validation_error',
                $errors
            );
        });

        $this->renderable(function (AuthenticationException $e) {
            return jsonErrorResponse(
                401,
                __('unauthorized_error'),
                'unauthorized_error'
            );
        });

        $this->renderable(function (Exception $e) {
            return jsonErrorResponse(
                500,
                __('server_error'),
                'server_error'
                [$e->getMessage()],
            );
        });
    }
}
