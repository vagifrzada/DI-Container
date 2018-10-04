<?php

namespace Vagif;

use Vagif\Exceptions\ServiceException;

class Container
{
    /**
     * Container for services
     *
     * @var array $services
     */
    protected $services = [];

    /**
     * Binding services to container
     * (User can override the service)
     * 
     * @param  string $service Name of the service
     * @param  callable|string $callable
     * @return void
     */
    public function bind(string $service, $callable): void
    {
        $this->services[$service] = $callable;
    }

    /**
     * Get a service from the container
     *
     * @param  string $service
     * @return mixed
     * @throws ServiceException
     */
    public function resolve(string $service)
    {
        if (! array_key_exists($service, $this->services)) {
            throw new ServiceException("Service {$service} doesn't exist !");
        }

        $service = $this->services[$service];

        return is_callable($service) ? call_user_func($service, $this) : $service;
    }
}
