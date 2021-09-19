<?php
require_once './vendor/autoload.php';
require_once './config/constants.php';

use Dotenv\Dotenv;
use TmdbProxy\Helpers\Config;

$dotenv = Dotenv::createImmutable(ROOT_DIR);
$dotenv->safeLoad();
$settings = require_once CONFIG_DIR . 'settings.php';
Config::init($settings);
return [
    'pdo' => [
        Config::get('database.type').':host='.Config::get('database.host').';dbname='.Config::get('database.name'),
        Config::get('database.username'),
        Config::get('database.password'),
    ],
    'namespace' => Config::get('atlas.namespace'),
    'directory' => Config::get('atlas.directory'),
];