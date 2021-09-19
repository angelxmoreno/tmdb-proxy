<?php
declare(strict_types=1);

namespace TmdbProxy\Helpers;

use League\Config\Configuration;
use Nette\Schema\Expect;

class Config
{
    /**
     * @var Configuration
     */
    protected static $config;

    public static function init($values = [])
    {
        static::$config = new Configuration([
            'debug' => Expect::bool(true),
            'tmdb' => Expect::structure([
                'apiKey' => Expect::string('')
            ]),
            'cache' => Expect::structure([
                'dir' => Expect::string('CACHE_DIR'),
                'ttlMinutes' => Expect::int(1)
            ]),
            'database' => Expect::structure([
                'type' => Expect::anyOf('mysql', 'postgresql', 'sqlite')->default('mysql'),
                'host' => Expect::string('localhost'),
                'name' => Expect::string('testdb'),
                'username' =>Expect::string('username'),
                'password' => Expect::string('password'),
            ]),
            'atlas' => Expect::structure([
                'namespace' =>  Expect::string('DataSource'),
                'directory' =>  Expect::string(SRC_DIR .'DataSource' ),
            ])
        ]);
        static::$config->merge($values);
    }

    public static function get($path)
    {
        return static::$config->get($path);
    }
}