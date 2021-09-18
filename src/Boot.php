<?php
declare(strict_types=1);

namespace TmdbProxy;

use Cache\Adapter\Filesystem\FilesystemCachePool;
use Cache\Bridge\SimpleCache\SimpleCacheBridge;
use Exception;
use Flight;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Symfony\Component\HttpClient\HttpClient;
use Dotenv\Dotenv;
use TmdbProxy\Helpers\Config;

class Boot
{
    public function init(): Boot
    {
        $this->loadEnv();
        $this->setVariables();
        $this->createCacheEngine();
        $this->createHttpClient();
        $this->setErrorHandler();

        return $this;
    }

    protected function loadEnv()
    {
        $dotenv = Dotenv::createImmutable(ROOT_DIR);
        $dotenv->safeLoad();
    }

    protected function setVariables()
    {
        $settings = require_once CONFIG_DIR . 'settings.php';
        Config::init($settings);
        Flight::set('flight.log_errors', true);
    }

    protected function createCacheEngine()
    {
        $filesystemAdapter = new Local(Config::get('cache.dir'));
        $filesystem = new Filesystem($filesystemAdapter);
        $pool = new FilesystemCachePool($filesystem);
        Flight::set('CACHE_ENGINE', new SimpleCacheBridge($pool));
    }

    protected function createHttpClient()
    {
        Flight::set('HTTP_CLIENT', HttpClient::create());
    }

    protected function setErrorHandler()
    {
        Flight::map('error', function (Exception $ex) {
            header('Content-type: application/json');
            $statusCode = $ex->getCode() > 99 ? $ex->getCode() : 400;
            $payload = [
                'code' => $ex->getCode(),
                'success' => false,
            ];

            if (Flight::get('debug')) {
                $payload = array_merge($payload, [
                    'type' => get_class($ex),
                    'message' => $ex->getMessage(),
                    'file' => $ex->getFile(),
                    'line' => $ex->getLine(),
                    'trace' => $ex->getTrace(),
                ]);
            }
            Flight::halt($statusCode, json_encode($payload));
        });
    }

    public function loadRoutes(): Boot
    {
        require_once CONFIG_DIR . 'routes.php';

        return $this;
    }

    public function start()
    {
        Flight::start();
    }
}