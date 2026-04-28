<?php

return [
    'default' => 'reverb',

    'apps' => [
        'reverb' => [
            'key' => env('REVERB_APP_KEY', 'fitarself-key'),
            'secret' => env('REVERB_APP_SECRET', 'fitarself-secret'),
            'app_id' => env('REVERB_APP_ID', 'fitarself'),
            'options' => [
                'host' => env('REVERB_HOST', 'localhost'),
                'port' => env('REVERB_PORT', 8080),
                'scheme' => env('REVERB_SCHEME', 'http'),
                'useTLS' => env('REVERB_SCHEME', 'http') === 'https',
            ],
            'allowed_origins' => ['*'],
            'ping_interval' => 60,
            'activity_timeout' => 300,
            'max_message_size' => 10000,
        ],
    ],
];
