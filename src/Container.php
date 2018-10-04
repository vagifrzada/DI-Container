<?php

namespace Vagif;

use Vagif\Exceptions\ServiceException;

class Container
{
    /**
     * Container for services
     */
    protected $services = [];

    /**
     * Binding services to container
     * (User can override the service)
     * 
     * @param  string   $name     Name of the service
     * @param  callable $callable Callable
     * @return void
     */
    public function bind(string $name, callable $callable): void
    {
        $this->services[$name] = $callable;
    }

    /**
     * Get a service from the container
     *
     * @param  string $service
     * @return mixed
     * @throws ServiceException
     */
    public function make(string $service)
    {
        if (! array_key_exists($service, $this->services)) {
            throw new ServiceException("Service {$service} doesn't exist !");
        }

        return call_user_func($this->services[$service], $this);
    }
}
