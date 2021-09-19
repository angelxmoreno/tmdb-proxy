<?php

return [
    'debug' => isset($_ENV['DEBUG']) ? filter_var($_ENV['DEBUG'], FILTER_VALIDATE_BOOLEAN) : true,
    'tmdb' => [
        'apiKey' => $_ENV['TMDB_API_KEY']
    ],
    'cache' => [
        'dir' => CACHE_DIR,
        'ttlMinutes' => isset($_ENV['CACHE_TTL_MINUTES']) ? filter_var($_ENV['CACHE_TTL_MINUTES'], FILTER_VALIDATE_INT) : 1
    ],
    'database' => [
        'host' => $_ENV['DB_HOST'],
        'name' => $_ENV['DB_NAME'],
        'username' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWD'],
    ],
    'atlas' => [
        'namespace' => 'TmdbProxy\DataSource',
        'directory' => dirname(__DIR__) . '/src/DataSource',
    ]
];