<?php
namespace Container;

use Services\Consumer\Consumer;
use Services\Producer\Producer;

class FactoryContainer
{
    protected array $services = [];

    //Déclare un service
    public function register (string $className) :self
    {
        $reflectClass = new \ReflectionClass($className);
        $constructor = $reflectClass->getConstructor();
        $arguments = [];
        if ($constructor != null) {
            foreach ($constructor->getParameters() as $parameter)
            {
                if (! $this->isRegistered($parameter->getClass()->getName()))
                    $this->register($parameter->getClass()->getName());
                array_push($arguments, $this->getService($parameter->getClass()->getName()));
            }
            $this->services[$className] = function () use ($className, $arguments) { return new $className(...$arguments); };
        }
        else {
            // If it's a "simple" object (like an array, splobject, splstorage, etc...) we consider it as a singleton
            $this->services[$className] = new $className(...$arguments);
        }
        return $this;
    }

    //Acceder au service
    public function getService ($className)
    {
        $service = $this->services[$className];
        if ($service instanceof \Closure) {
            return $service();
        }
        else {
            return $service;
        }
    }

    public function isRegistered(string $className)
    {
        return array_key_exists($className, $this->services);
    }
}

