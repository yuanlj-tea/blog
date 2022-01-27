<?php

namespace App\Http\Middleware;

use App\Libs\RequestEnv;
use Closure;
use OpenTracing\Span;
use App\Libs\Facade\SpanFacade;
use App\Libs\Trace\TraceClient;

class TraceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $traceId = $request->header(RequestEnv::TRACE_ID, gen_trace_id());
        RequestEnv::setTraceId($traceId, true);

        $tracer = TraceClient::getInstance()->getTracer();
        $span = SpanFacade::buildRequestSpan();

        $response = $next($request);
        if ($span instanceof Span) {
            $span->finish();
        }

        $tracer->flush();

        return $response;
    }
}
