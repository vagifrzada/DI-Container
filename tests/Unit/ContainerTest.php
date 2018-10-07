<?php

namespace Tests\Unit;

use Vagif\Container;
use PHPUnit\Framework\TestCase;
use Vagif\Exceptions\ServiceNotFoundException;

class ContainerTest extends TestCase
{
    public function testGetPrimitiveData()
    {
        $container = new Container;
        $container->bind('config', [
            'host' => '127.0.0.1',
            'db'   => 'testing'
        ]);

        $this->assertArrayHasKey('host', $container->resolve('config'));       
        $this->assertArrayHasKey('db', $container->resolve('config'));
        
        $this->assertEquals('127.0.0.1', $container->resolve('config')['host']);
        $this->assertEquals('testing', $container->resolve('config')['db']);
    }

    public function testGetServiceFromContainer()
    {
        $container = new Container;
        $container->bind('aws', function () {
            return new \stdClass();
        });

        $this->assertInstanceOf(\stdClass::class, $container->resolve('aws'));
    }

    public function testExceptionWhenServiceNotFound()
    {
        $this->expectException(ServiceNotFoundException::class);

        $container = new Container;
        $container->resolve('someService');
    }

    public function testCanBindObjectToContainer()
    {
        $object = new class {
            public function testing()
            {
                return 'Testing';
            }
        };

        $container = new Container;
        $container->bind('test', [$object, 'testing']);

        $this->assertEquals('Testing', $container->resolve('test'));
    }

    public function testSingletonServices()
    {
        $container = new Container;
        $container->singleton('service', function () {
            return new \stdClass;
        });

        $service = $container->resolve('service');
        $service2 = $container->resolve('service');

        $this->assertSame($service, $service2);
    }

    public function testContainerWithinContainer()
    {
        $container = new Container;
        $container->bind('containerAgain', function (Container $container) {
             return $container;   
        });

        $this->assertSame($container, $container->resolve('containerAgain'));
    }
}
