<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
        'senha',
        'Senha',
        'SenhaMD5'
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
    
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        $data = [
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ];

        if (config('app.env') == 'local') {
            $data['trace'] = $exception->getTrace();
        }

        $getCode = $exception->getCode();
        $getCode = $getCode && in_array($getCode, array_keys(Response::$statusTexts)) ? $getCode : 500;

        return response()->json([
            'success' => false,
            'message' => $exception->getMessage(),
            'data' => $data
        ], $getCode);
    }
}
