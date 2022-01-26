<?php

return [
    'default' => \Trace\Constants::JAEGER,
    'enable' => [
        'guzzle' => false,
        'redis' => false,
        'db' => false,
        'method' => false,
        'exception' => false,
    ],
    'tracer' => [
        \Trace\Constants::JAEGER => [
            'driver' => '',
            'app_name' => 'your-app-name',
            'options' => [
                /*
                 * You can uncomment the sampler lines to use custom strategy.
                 *
                 * For more available configurations,
                 * @see https://github.com/jonahgeorge/jaeger-client-php
                 */
                'sampler' => [
                    'type' => \Jaeger\SAMPLER_TYPE_CONST,
                    'param' => true,
                ],
                'local_agent' => [
                    'reporting_host' => '127.0.0.1',
                    'reporting_port' => 5775,
                ],
            ],
        ],
    ],
    'tags' => [
        'http_client' => [
            'http.url' => 'http.url',
            'http.method' => 'http.method',
            'http.status_code' => 'http.status_code',
        ],
        'redis' => [
            'arguments' => 'arguments',
            'result' => 'result',
        ],
        'db' => [
            'db.query' => 'db.query',
            'db.statement' => 'db.statement',
            'db.query_time' => 'db.query_time',
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
    ],
];
