<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
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
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if($e instanceof \Illuminate\Session\TokenMismatchException){
            return response(json_encode(['code'=>0,'info'=>'缺少csrf_token']),200)->header('Access-Control-Allow-Origin','*')
                ->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, Accept,Authorization,X-Requested-With,foo')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT , X-CSRF-TOKEN,OPTIONS')
                ->header('Access-Control-Allow-Credentials', 'true');
        }
        return parent::render($request, $e);
    }
}
