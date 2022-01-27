<?php

namespace Trace;

class SpanTagManager
{
    private $tags = [
        'http_client' => [
            'http.status_code' => 'status',
        ],
        'redis' => [
            'arguments' => 'arguments',
            'result' => 'result',
        ],
        'db' => [
            'db.query' => 'db.query',
            'db.statement' => 'db.sql',
            'db.query_time' => 'db.query_time',
        ],
        'rpc' => [
            'path' => 'rpc.path',
            'status' => 'rpc.status',
        ],
        'exception' => [
            'class' => 'exception.class',
            'code' => 'exception.code',
            'message' => 'exception.message',
            'stack_trace' => 'exception.stack_trace',
        ],
        'request' => [
            'path' => 'request.path',
            'method' => 'request.method',
            'header' => 'request.header',
        ],
        'coroutine' => [
            'id' => 'coroutine.id',
        ],
        'response' => [
            'status_code' => 'response.status_code',
        ],
    ];

    public function apply(array $tags)
    {
        $this->tags = array_replace_recursive($this->tags, $tags);
    }

    public function get(string $type, string $name): string
    {
        return $this->tags[$type][$name];
    }

    public function has(string $type, string $name)
    {
        return isset($this->tags[$type][$name]);
    }
}