<?php

namespace Tests\Unit;

use Vagif\Container;
use PHPUnit\Framework\TestCase;
use Vagif\Exceptions\ServiceException;

class ContainerTest extends TestCase
{
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
        $this->expectException(ServiceException::class);

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
}