<?php

/*
 * This file is part of OAuth 2.0 Laravel.
 *
 * (c) Luca Degasperi <packages@lucadegasperi.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Middleware;

use AjaxResponse;
use Closure;
use Illuminate\Http\JsonResponse;
use League\OAuth2\Server\Exception\OAuthException;

/**
 * This is the exception handler middleware class.
 *
 * @author Luca Degasperi <packages@lucadegasperi.com>
 */
class OAuthExceptionHandlerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $response = $next($request);
            // Was an exception thrown? If so and available catch in our middleware
            if (isset($response->exception) && $response->exception) {
                throw $response->exception;
            }

            return $response;
        } catch (OAuthException $e) {
            if (mb_strpos('oauth/authorize', $request->path()) !== false) {
                //如果是授权页面抛出异常跳转到页面，并提示
//                return response()->view('oauth.error', [
//                    'errorType' => $e->errorType,
//                    'errorMsg' => $e->getMessage(),
//                ]);
                $errMsg = [
                    'errorType' => $e->errorType,
                    'errorMsg' => $e->getMessage(),
                ];
                return AjaxResponse::fail($errMsg);
            }

            $data = [
                'code' => 0,
                'msg' => $e->errorType . ': ' . $e->getMessage(),
                'data' => [],
            ];

            return new JsonResponse($data, $e->httpStatusCode, $e->getHttpHeaders());
        }
    }
}
