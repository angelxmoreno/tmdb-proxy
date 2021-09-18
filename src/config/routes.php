<?php

use TmdbProxy\RequestHandlers;

Flight::route('GET /test', function () {
    echo CACHE_DIR;
});

Flight::route('*', new RequestHandlers\ProxyRequestHandler());