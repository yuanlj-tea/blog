<?php

namespace Trace;

use Jaeger\Config;
use Trace\exception\InvalidParam;

class TracerFactory
{
    private static $instance = null;

    private $config;

    private $default;

    /**
     * @var \OpenTracing\Tracer
     */
    public static $tracer;

    private function __construct(array $config = [])
    {
        $this->config = !empty($config) ? $config : require_once __DIR__ . '/../publish/opentracing.php';
    }

    public static function getInstance($config = [])
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    /**
     * @return \Jaeger\Tracer|null
     * @throws InvalidParam
     */
    public function initTracer()
    {
        $this->default = $this->config['default'];

        switch ($this->default) {
            case 'jaeger':
                [$appName, $options] = $this->parseConfig();

                $jaegerCfg = new Config($options, $appName);
                $tracer = $jaegerCfg->initializeTracer();
                self::setTracer($tracer);

                return $tracer;
            default:
                throw new InvalidParam();
        }
    }

    public static function setTracer(\OpenTracing\Tracer $tracer)
    {
        self::$tracer = $tracer;
    }

    /**
     * @return array
     */
    private function parseConfig()
    {
        $cfg = $this->config['tracer'][$this->default];
        return [
            $cfg['app_name'],
            $cfg['options'],
        ];
    }
}