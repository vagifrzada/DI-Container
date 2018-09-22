<?php

namespace Vagif;

use Vagif\Exceptions\ServiceAlreadyExistsException;

class Container
{
    /**
     * Container for services
     */
    protected $services = [];

    /**
     * Binding services to container.
     * 
     * @param string $name Name of the service
     * @param callable $callable Callable
     * @return void
     */
    public function bind(string $name, callable $callable): void
    {
        if (array_key_exists($name, $this->services)) {
            throw new ServiceAlreadyExistsException("Service: {$name} already exists.");
        }

        $this->services[$name] = $callable;
    }

    /**
     * Displaying our services (testing)
     * 
     * @return string
     */
    public function __toString()
    {
        return implode(
            ', ', array_keys($this->services)
        );
    }
}