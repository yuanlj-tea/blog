<?php

namespace Trace;

use OpenTracing\GlobalTracer;
use OpenTracing\Span;
use const OpenTracing\Formats\TEXT_MAP;
use const OpenTracing\Tags\SPAN_KIND;
use const OpenTracing\Tags\SPAN_KIND_RPC_SERVER;

trait SpanStarter
{
    protected function startSpan(string $name, array $option = [], string $kind = SPAN_KIND_RPC_SERVER, array $header = []): Span
    {
        $tracer = TracerFactory::$tracer;
        $root = ReqCtx::get(Constants::TRACER_ROOT);

        if (!$root instanceof Span) {
            if ($this->isCli()) {
                $root = $tracer->startSpan($name, $option);
                $root->setTag(SPAN_KIND, $kind);
                ReqCtx::set(Constants::TRACER_ROOT, $root);

                return $root;
            }

            $carrier = $this->parseHeader($header);
            $spanContext = $tracer->extract(TEXT_MAP, $carrier);
            if ($spanContext) {
                $option[Constants::CHILD_OF] = $spanContext;
            }

            $root = $tracer->startSpan($name, $option);
            $root->setTag(SPAN_KIND, $kind);
            ReqCtx::set(Constants::TRACER_ROOT, $root);

            return $root;
        } else {
            $option[Constants::CHILD_OF] = $root->getContext();
            $child = $tracer->startSpan($name, $option);
            $child->setTag(SPAN_KIND, $kind);

            return $child;
        }
    }

    protected function isCli()
    {
        return preg_match("/cli/i", php_sapi_name()) ? true : false;
    }

    protected function parseHeader($headers = [])
    {
        $carrier = array_map(function ($header) {
            return $header[0];
        }, $headers);

        return $carrier;
    }
}