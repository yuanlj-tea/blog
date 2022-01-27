<?php

return [
    'default' => \Trace\Constants::JAEGER,
    'enable' => [
        'guzzle' => true,
        'redis' => true,
        'db' => true,
        'method' => true,
        'response' => true,
        'exception' => true,
    ],
    'tracer' => [
        \Trace\Constants::JAEGER => [
            'app_name' => 'xyf-api-gateway',
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
                    'reporting_host' => 'localhost',
                    'reporting_port' => 5775,
                ],
                'ip_version' => \Jaeger\Config::IPV6,
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
            'command' => 'redis.command',
            'cost' => 'redis.cost',
        ],
        'db' => [
            'query' => 'db.query',
            'statement' => 'db.statement',
            'cost' => 'db.cost',
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
            'body' => 'request.body',
            'respcode' => 'resp.code',
            'respbody' => 'resp.body',
        ],
        'coroutine' => [
            'id' => 'coroutine.id',
        ],
        'response' => [
            'status_code' => 'response.status_code',
            'body' => 'response.body',
        ],
    ],
];