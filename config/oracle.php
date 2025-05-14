<?php

return [
    'oracle' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_PBB_TNS', ''),
        'host'           => env('DB_PBB_HOST', ''),
        'port'           => env('DB_PBB_PORT', '1521'),
        'database'       => env('DB_PBB_DATABASE', ''),
        'username'       => env('DB_PBB_USERNAME', ''),
        'password'       => env('DB_PBB_PASSWORD', ''),
        'charset'        => env('DB_PBB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PBB_PREFIX', ''),
        'prefix_schema'  => env('DB_PBB_SCHEMA_PREFIX', ''),
        'edition'        => env('DB_PBB_EDITION', 'ora$base'),
        'server_version' => env('DB_PBB_SERVER_VERSION', '11g'),
    ],
];
