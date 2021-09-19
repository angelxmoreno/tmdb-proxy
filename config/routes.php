<?php

use Atlas\Mapper\Mapper;
use Atlas\Orm\Atlas;
use TmdbProxy\DataSource\User\User;
use TmdbProxy\RequestHandlers;

Flight::route('GET /test', function () {
    /** @var Mapper|User $Users */
    $Users = Flight::get('ATLAS')->mapper(User::class);
    $data = $Users->select()->fetchRows();

    Flight::json(compact('data'));
});

Flight::route('*', new RequestHandlers\ProxyRequestHandler());