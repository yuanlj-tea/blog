<?php

namespace App\Libs\Facade;

use App\Libs\Trace\Span\SpanHelper;

/**
 * @method static buildRequestSpan(): ?Span
 * @method static appendExceptionToSpan(\Throwable $t)
 * @method static appendResponseToSpan($statusCode, $resp = null)
 * @method static appendSqlToSpan($sql): ?Span
 * @method static appendRedisToSpan($command): ?Span
 * @method static appendGuzzleToSpan(string $path, string $method, $body)
 * @method static appendTraceToSpan()
 */
class SpanFacade extends Facade
{
    public function getFacadeAccessor()
    {
        return SpanHelper::class;
    }

}