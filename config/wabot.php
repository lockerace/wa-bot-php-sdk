<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Queue Connection Name
    |--------------------------------------------------------------------------
    |
    | Laravel's queue supports a variety of backends via a single, unified
    | API, giving you convenient access to each backend using identical
    | syntax for each. The default queue connection is defined below.
    |
    */

    'default' => env('WA_BOT_CONNECTION', 'local'),
    'connections' => [
        'local' => [
            'host' => env('WA_BOT_HOST', 'localhost'),
            'port' => env('WA_BOT_PORT', 3001),
            'scheme' => env('WA_BOT_SCHEME', 'http'),
            'api_key' => env('WA_BOT_API_KEY', ''),
            'channel_prefix' => env('WA_BOT_CHANNEL_PREFIX', 'wa-bot'),
        ],
    ],
];
