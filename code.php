<?php

/**
 * Dependency Injection Container AKA Service Container
 *
 */

use Vagif\Container;

require __DIR__ .'/vendor/autoload.php';

$di = new Container;

$di->bind('aws', function (Container $container) {
    return new class ($container->make('db'))
    {
        protected $db;

        public function __construct($db)
        {
            $this->db = $db;
        }

        public function getDb()
        {
            return $this->db;
        }
    };
});

$di->bind('db', function () {
    return new class {
        public $name = 'Access to mysql database';
    };
});

$aws = $di->make('aws');
var_dump($aws);
