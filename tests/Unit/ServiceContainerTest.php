<?php

namespace Tests\Unit;

use Vagif\Container;
use PHPUnit\Framework\TestCase;
use Vagif\Exceptions\ServiceException;

class ServiceContainerTest extends TestCase
{
    public function testGetServiceFromContainer()
    {
        $container = new Container;
        $container->bind('aws', function (Container $container) {
            return 'AWS service';
        });

        $this->assertEquals('AWS service', $container->make('aws'));
    }

    public function testExceptionWhenServiceNotFound()
    {
        $this->expectException(ServiceException::class);

        $container = new Container;
        $container->make('someService');
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

        $this->assertEquals('Testing', $container->make('test'));
    }
}