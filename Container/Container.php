<?php
namespace Container;

use Services\Consumer\Consumer;
use Services\Producer\Producer;

class Container
{
    protected array $services = [];

    //Déclare un service
    public function register (string $className) :self
    {

        $reflectClass = new \ReflectionClass($className);
        $constructor = $reflectClass->getConstructor();
        $arguments = [];
        // I use the fact that splobject and splstorage does not have constructor
        if ($constructor != null) {
            foreach ($constructor->getParameters() as $parameter)
            {
                if (! $this->isRegistered($parameter->getClass()->getName()))
                    $this->register($parameter->getClass()->getName());
                array_push($arguments, $this->getService($parameter->getClass()->getName()));
            }
        }
        $this->services[$className] = new $className(...$arguments);
        return $this;
    }

    //Acceder au service
    public function getService ($className)
    {
        return $this->services[$className];
    }

    public function isRegistered(string $className)
    {
        return array_key_exists($className, $this->services);
    }
}

