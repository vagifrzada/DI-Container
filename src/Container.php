<?php

namespace Vagif;

use Vagif\Exceptions\ServiceNotFoundException;

class Container
{
    /**
     * Container for services
     *
     * @var array $services
     */
    protected $services = [];

    /**
     * Container for singletons services
     *
     * @var array $singletons
     */
    protected $singletons = [];

    /**
     * Binding services to container
     * (User can override the service)
     * 
     * @param  string $service Name of the service
     * @param  callable|string $value
     * @param  bool $locked
     * @return void
     */
    public function bind(string $service, $value, $locked = false): void
    {
        $this->services[$service] = compact('value', 'locked');
    }

    /**
     * Binding singleton services to container
     * 
     * @param  string $service Name of the service
     * @param  callable|string $value
     * @return void
     */
    public function singleton(string $service, $value): void
    {
        $this->bind($service, $value, true);
    }

    /**
     * @param string $service
     * @return mixed
     * @throws ServiceNotFoundException
     */
    public function resolve(string $service)
    {
        $this->checkIfServiceExists($service);

        if (isset($this->singletons[$service])) {
            return $this->singletons[$service];
        }

        $abstract = $this->services[$service];

        $data = is_callable($abstract['value']) 
            ? call_user_func($abstract['value'], $this) 
            : $abstract['value'];

        if ($this->isSingletonService($abstract)) {
            $this->singletons[$service] = $data;
        }

        return $data;
    }


    /**
     * Checking if user attempted to registering singleton services
     *
     * @param array $abstract
     * @return bool
     */
    protected function isSingletonService(array $abstract): bool
    {
        return isset($abstract['locked']) && $abstract['locked'] === true;
    }

    /**
     * @param string $service
     * @return void
     * @throws ServiceNotFoundException
     */
    protected function checkIfServiceExists(string $service): void
    {
        if (! array_key_exists($service, $this->services)) {
            throw new ServiceNotFoundException("Service {$service} doesn't exist !");
        }
    }
}
