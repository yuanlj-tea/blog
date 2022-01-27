<?php

namespace App\Libs\Trace;

use OpenTracing\Tracer;
use Trace\SpanTagManager;
use Trace\SwitchManager;
use Trace\TracerFactory;

class TraceClient
{
    private static $instance = null;

    /**
     * @var mixed
     */
    private $config;

    /**
     * @var \OpenTracing\Tracer
     */
    public static $tracer;

    private function __construct()
    {
        $this->config = config('trace');
    }

    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @return \Jaeger\Tracer|null
     * @throws \Trace\exception\InvalidParam
     */
    public function getTracer()
    {
        if (!self::$tracer instanceof Tracer) {
            self::$tracer = TracerFactory::getInstance($this->config)->initTracer();
        }

        return self::$tracer;
    }

    /**
     * @return SpanTagManager
     */
    public function getSpanTagManager()
    {
        $spanTagManager = new SpanTagManager();
        $spanTagManager->apply($this->config['tags'] ?? []);

        return $spanTagManager;
    }

    /**
     * @return SwitchManager
     */
    public function getSwitchManager()
    {
        $switchManager = new SwitchManager();
        $switchManager->apply($this->config['enable'] ?? []);

        return $switchManager;
    }
}