<?php

namespace Src\Core\Container;

class Container
{
    private static array $instances = [];
    private array $bindings = [];

    public static function singleton(string $class, $build = null)
    {
        if (!array_key_exists($class, self::$instances)) {
            // self::$instances[$class] = new $class();
            /** @phpstan-ignore-next-line */
            match (true) {
                is_null($build) => self::$instances[$class] = new $class(),
                is_string($build) => self::$instances[$class] = new $build(),
                is_callable($build) => self::$instances[$class] = $build(),
                is_object($build) => self::$instances[$class] = $build,
            };
        }

        return self::$instances[$class];
    }

    public static function resolve(string $class)
    {
        return self::$instances[$class] ??= new $class();
    }

    public static function getInstances(): array
    {
        return self::$instances;
    }

    public function get($name)
    {
        $this->bindings = self::getInstances();
        if (!isset($this->bindings[$name])) {
            throw new \Exception("Target binding [$name] does not exist.");
        }
        $factory = $this->bindings[$name];
        return $factory($this);
    }

    public static function build(string $class)
    {
        try {
            $reflection = new \ReflectionClass($class);
        } catch (\ReflectionException $e) {
            throw new \Exception("Class {$class} not found", 0, $e);
        }

        if (!$reflection->isInstantiable()) {
            throw new \Exception("Class {$class} is not instantiable");
        }

        $constructor = $reflection->getConstructor();
        if (is_null($constructor)) {
            return new $class();
        }
        $parameters = $constructor->getParameters();
        $dependencias = [];
        foreach ($parameters as $parameter) {
            $type = $parameter->getType();

            if (!$type instanceof \ReflectionNamedType || $type->isBuiltin()) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencias[] = $parameter->getDefaultValue();
                } elseif ($parameter->isVariadic()) {
                    $dependencias[] = [];
                } else {
                    throw new \Exception("Cannot resolve class {$class}");
                }
            }
            /** @phpstan-ignore-next-line */
            $name = $type->getName();
            try {
                /** @phpstan-ignore-next-line */
                $dependencia = (new static())->get($name);
                $dependencias[] = $dependencia;
            } catch (\Exception $e) {
                if ($parameter->isOptional()) {
                    $dependencias[] = $parameter->getDefaultValue();
                } else {
                    /** @phpstan-ignore-next-line */
                    $dependencia =  self::build($parameter->getType()->getName());
                    self::singleton($name, $dependencia);
                }
                /** @phpstan-ignore-next-line */
                $dependencias[] = $dependencia;
            }
        }
        return $reflection->newInstanceArgs($dependencias);
    }

}
