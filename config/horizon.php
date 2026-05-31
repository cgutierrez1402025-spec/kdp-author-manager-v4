<?php

use Laravel\Horizon\Horizon;

return [
    'use' => 'redis',

    'redis' => [
        'cluster' => env('REDIS_CLUSTER', false),

        'prefix' => env('HORIZON_PREFIX', 'horizon:'),

        'queue' => env('HORIZON_QUEUE', '{default}'),
    ],

    'paths' => [
        'base' => env('HORIZON_PATH', '/horizon'),
    ],

    'middleware' => [
        'web',
        \App\Http\Middleware\EnsureMfaForRoles::class,
    ],

    'waits' => [
        'redis' => 2,
    ],

    'trim' => [
        'recent' => 60,
        'pending' => 60,
        'completed' => 60,
        'recent_failed' => 10080,
        'failed' => 10080,
        'monitored' => 10080,
        'tail' => 60,
    ],
];