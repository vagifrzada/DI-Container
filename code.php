<?php

/**
 * Dependency Injection Container
 * 
 * Service Container 
 */

require __DIR__ .'/vendor/autoload.php';


$di = new \Vagif\Container;

$di->bind('aws', function () {
    return new class {
        public $name = 'AWS Services';
    };
});


echo $di;