<?php

namespace Trace;


use OpenTracing\Span;

class SwitchManager
{
    /**
     * @var array
     */
    private $config = [
        'guzzle' => false,
        'redis' => false,
        'db' => false,
        'method' => false,
        'error' => false,
    ];

    public function apply(array $config): void
    {
        $this->config = array_replace($this->config, $config);
    }

    public function isEnable(string $identifier): bool
    {
        if (!isset($this->config[$identifier])) {
            return false;
        }

        return $this->config[$identifier] && ReqCtx::get(Constants::TRACER_ROOT) instanceof Span;
    }
}