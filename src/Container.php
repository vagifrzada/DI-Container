<?php

namespace Vagif;

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
     */
    public function bind(string $name, callable $callable) : void
    {
        if (array_key_exists($name, $this->services)) {
            throw new \Exception("Service: {$name} already exists.");
        }

        $this->services[$name] = $callable;
    }


    public function __toString()
    {
        return implode(
            ', ', array_keys($this->services)
        );
    }
}