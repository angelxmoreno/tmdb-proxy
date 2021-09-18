<?php
require_once '../vendor/autoload.php';
require_once '../src/config/constants.php';

use TmdbProxy\Boot;

$app = new Boot();
$app->init()
    ->loadRoutes()
    ->start();


