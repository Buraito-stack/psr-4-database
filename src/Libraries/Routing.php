<?php

namespace MiniMarkPlace\Libraries;

use ReflectionClass;
use ReflectionMethod;
use Exception;

class Routing
{
    private array $routes = [];

    public function add(string $method, string $path, $handler): void
    {
        $this->routes[$method][$path] = $handler;
    }

    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }

        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];

            if (is_callable($handler)) {
                return call_user_func($handler);
            }

            if (is_array($handler)) {
                [$controllerClass, $methodName] = $handler;

                if (class_exists($controllerClass) && method_exists($controllerClass, $methodName)) {
                    $controller = $this->resolveClass($controllerClass);
                    return $this->invokeMethod($controller, $methodName);
                }

                throw new Exception("Controller or method does not exist.");
            }
        }

        return '404 Not Found';
    }

    protected function resolveClass(string $class)
    {
        $reflectionClass = new ReflectionClass($class);
        $constructor = $reflectionClass->getConstructor();

        if ($constructor === null) {
            return $reflectionClass->newInstance();
        }

        $dependencies = [];
        foreach ($constructor->getParameters() as $parameter) {
            $type = $parameter->getType();

            if ($type && !$type->isBuiltin()) {
                $dependencies[] = $this->resolveClass($type->getName());
            } else {
                throw new Exception("Unresolvable dependency: {$parameter->getName()}");
            }
        }

        return $reflectionClass->newInstanceArgs($dependencies);
    }

    protected function invokeMethod(object $controller, string $method)
    {
        $reflectionMethod = new ReflectionMethod($controller, $method);
        $dependencies = [];

        foreach ($reflectionMethod->getParameters() as $parameter) {
            $type = $parameter->getType();

            if ($type && !$type->isBuiltin()) {
                $dependencies[] = $this->resolveClass($type->getName());
            } else {
                throw new Exception("Unresolvable dependency: {$parameter->getName()}");
            }
        }

        return $reflectionMethod->invokeArgs($controller, $dependencies);
    }
}
