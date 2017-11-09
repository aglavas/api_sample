<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;
use Jrean\UserVerification\Exceptions\TokenMismatchException;
use Jrean\UserVerification\Exceptions\UserIsVerifiedException;
use Jrean\UserVerification\Exceptions\UserNotFoundException;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\App;

class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ValidationException) {
            return $this->validationOutput($exception);
        } elseif ($exception instanceof TokenBlacklistedException) {
            return $this->errorOutput($exception->getMessage(), 403);
        } elseif ($exception instanceof TokenExpiredException) {
            return $this->errorOutput($exception->getMessage(), 401);
        } elseif ($exception instanceof JWTException) {
            return $this->errorOutput($exception->getMessage(), 403);
        } elseif ($exception instanceof \PDOException) {
            return $this->errorOutput("Unable to save data into DB!.", 500);
        } elseif ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorOutput("Route not found", 404);
        } elseif ($exception instanceof NotFoundHttpException) {
            return $this->errorOutput("Route not found", 404);
        } elseif ($exception instanceof AuthenticationException) {
            return $this->errorOutput("Token not provided, authentication needed.", 401);
        } elseif ($exception instanceof UserNotFoundException) {
            return $this->errorOutput("No user found for the given email address.", 404);
        } elseif ($exception instanceof UserIsVerifiedException) {
            return $this->errorOutput("This user is already verified.", 400);
        } elseif ($exception instanceof TokenMismatchException) {
            return $this->errorOutput("Wrong verification token.", 403);
        } elseif ($exception instanceof HttpException) {
            return $this->errorOutput($exception->getMessage(), $exception->getStatusCode());
        } elseif ($exception instanceof FatalErrorException) {
            if (App::environment() == 'local') {
                return response([
                    'errors' => $this->mapExceptionWithTrace($exception)
                ], 500);
            }

            return $this->errorOutput("Internal server error", 500);
        } elseif ($exception instanceof Exception) {
            return response([
                'errors' => $this->mapExceptionWithTrace($exception)
            ], 500);
        }

        return parent::render($request, $exception);
    }

    public function errorOutput($message, $code)
    {
        $res =  [
            'error' => [
                [
                    'type' => "general",
                    'field' => null,
                    'message' => $message
                    //'message' => is_array($message) ? print_r($message) : $message
                ]
            ]
        ];

        return ( new Response($res, $code) )->header('Content-Type', 'application/json');
    }

    public function validationOutput($e)
    {
        $res = [
            'error' => [
                [
                    'type' => "validation",
                    'field' => key($e->response),
                    'message' => $e->response[key($e->response)][0]
                ]
            ]
        ];

        return ( new Response($res, 422) )->header('Content-Type', 'application/json');
    }

    /**
     * @param Exception $exception
     * @return array
     */

    private function mapExceptionWithTrace($exception)
    {
        return [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => collect($exception->getTrace())
                ->map(function ($item) {
                    return [
                        'class' => isset($item['class']) ? $item['class'] : null,
                        'function' => isset($item['function']) ? $item['function'] : null,
                        'file' => isset($item['file']) ? $item['file'] : null,
                        'line' => isset($item['line']) ? $item['line'] : null
                    ];
                })
                ->all()
        ];
    }
}
