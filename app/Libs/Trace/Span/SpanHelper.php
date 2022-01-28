<?php

namespace App\Libs\Trace\Span;


use App\Libs\RequestEnv;
use App\Libs\Trace\Resp;
use App\Libs\Trace\TraceClient;
use App\Libs\Trace\TraceSwitch;
use Illuminate\Support\Str;
use OpenTracing\Span;
use Trace\SpanStarter;
use OpenTracing\Tracer;
use Trace\SwitchManager;
use Trace\SpanTagManager;
use const OpenTracing\Tags\SPAN_KIND_RPC_SERVER;

class SpanHelper
{
    use SpanStarter;

    /**
     * @var Tracer
     */
    private $tracer;

    /**
     * @var SwitchManager
     */
    private $switch;

    /**
     * @var SpanTagManager
     */
    private $spanTag;

    private $noTracePath = [
        'metrics*',
    ];

    public function __construct()
    {
        $traceClient = TraceClient::getInstance();

        $this->tracer = $traceClient->getTracer();
        $this->switch = $traceClient->getSwitchManager();
        $this->spanTag = $traceClient->getSpanTagManager();
    }

    /**
     * is record trace
     * @return bool
     */
    private function isAddTrace(): bool
    {
        if (!TraceSwitch::getSwitch()) {
            return false;
        }

        $path = request()->path();

        foreach ($this->noTracePath as $v) {
            if (Str::is($v, $path)) {
                TraceSwitch::setSwitch(false);
                return false;
            }
        }
        return true;
    }

    /**
     * build request span
     * @return Span|null
     */
    public function buildRequestSpan(): ?Span
    {
        if (!$this->isAddTrace()) {
            return null;
        }
        $request = request();

        $path = $request->getPathInfo();
        $method = $request->getMethod();
        $header = $request->headers->all();

        $span = $this->startSpan('request ' . $path, [], SPAN_KIND_RPC_SERVER, $header);

        $span->setTag($this->spanTag->get('request', 'path'), $path);
        $span->setTag($this->spanTag->get('request', 'method'), $method);
        $span->setTag('trace_id', RequestEnv::getTraceId());
        if (!empty($orderNo = RequestEnv::getEnv('order_no'))) {
            $span->setTag('order_no', $orderNo);
        }
        foreach ($header as $k => $v) {
            $span->setTag($this->spanTag->get('request', 'header') . '.' . $k, implode(',', $v));
        }
        $span->setTag($this->spanTag->get('request', 'body'), cjson_encode($request->all()));

        return $span;
    }

    /**
     * appen exception to span
     * @param Span $span
     * @param \Throwable $t
     */
    public function appendExceptionToSpan(\Throwable $t)
    {
        if (!$this->isAddTrace()) {
            return;
        }
        if (!$this->switch->isEnable('exception')) {
            return;
        }

        $span = $this->startSpan('exception');
        $span->setTag($this->spanTag->get('exception', 'class'), get_class($t));
        $span->setTag($this->spanTag->get('exception', 'code'), (string)$t->getCode());
        $span->setTag($this->spanTag->get('exception', 'message'), $t->getMessage());
        $span->setTag($this->spanTag->get('exception', 'stack_trace'), $t->getTraceAsString());

        $span->finish();
    }

    /**
     * appen response to span
     * @param $statusCode
     * @param null $resp
     */
    public function appendResponseToSpan($statusCode, $resp = null)
    {
        if (!$this->isAddTrace()) {
            return;
        }
        if (!$this->switch->isEnable('response')) {
            return;
        }

        $body = Resp::getRawRespData() ?? (is_array($resp) ? cjson_encode($resp) : (string)$resp);

        $span = $this->startSpan('response');
        $span->setTag($this->spanTag->get('response', 'body'), $body);
        $span->setTag($this->spanTag->get('response', 'status_code'), $statusCode);
        if (!empty($orderNo = RequestEnv::getEnv('order_no'))) {
            $span->setTag('order_no', (string)$orderNo);
        }

        $span->finish();
    }

    /**
     * append sql to span
     * @param $sql
     * @param $cost
     * @return \OpenTracing\Span|void
     */
    public function appendSqlToSpan($sql): ?Span
    {
        if (!$this->switch->isEnable('db')) {
            return null;
        }

        $span = $this->startSpan('mysql');
        $span->setTag($this->spanTag->get('db', 'query'), $sql);

        return $span;
    }

    /**
     * append redis command to span
     * @param $command
     * @return null
     * @throws \Trace\exception\InvalidParam
     */
    public function appendRedisToSpan($command): ?Span
    {
        if (!$this->switch->isEnable('redis')) {
            return null;
        }

        $span = $this->startSpan('redis');
        $span->setTag($this->spanTag->get('redis', 'command'), $command);

        return $span;
    }

    /**
     * append http request to span
     * @param string $path
     * @param string $method
     * @param $body
     * @return Span|null
     */
    public function appendGuzzleToSpan(string $path, string $method, $body)
    {
        if (!$this->switch->isEnable('guzzle')) {
            return null;
        }

        $span = $this->startSpan('http_request ' . $method . ' ' . $path);
        $span->setTag($this->spanTag->get('request', 'path'), $path);
        $span->setTag($this->spanTag->get('request', 'method'), $method);
        $span->setTag($this->spanTag->get('request', 'body'), cjson_encode($body));

        return $span;
    }

    /**
     * append trace to span
     */
    public function appendTraceToSpan()
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 5);
        array_shift($trace);
        $trace = array_reverse($trace);

        $span = $this->startSpan('trace_info');
        $span->setTag('request_trace', cjson_encode($trace));
        $span->finish();
    }
}