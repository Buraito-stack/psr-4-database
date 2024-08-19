<?php

namespace MiniMarkPlace\Libraries;

use ReflectionClass;
use ReflectionMethod;
use Exception;

class Routing
{
    private array $routes = [];

    /**
     * Add a route to the routing table.
     *
     * @param string $method  
     * @param string $path     
     * @param callable|array $handler
     * @return void
     */
    public function add(string $method, string $path, $handler): void
    {
        $this->routes[$method][$path] = $handler;
    }

    /**
     *
     * @return mixed
     */
    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path   = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Check for overridden methods (PUT, DELETE)
        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }

        // Checking
        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];

            if (is_callable($handler)) {
                return call_user_func($handler);
            } elseif (is_array($handler)) {
                [$controllerClass, $methodName] = $handler;

                if (class_exists($controllerClass) && method_exists($controllerClass, $methodName)) {
                    $controller = $this->resolveClass($controllerClass);
                    return $this->invokeMethod($controller, $methodName);
                } else {
                    throw new Exception("Controller or method does not exist.");
                }
            }
        }

        return '404 Not Found';
    }

    /**
     *
     * @param string $class
     * @return object
     */
    private function resolveClass(string $class)
    {
        $reflectionClass = new ReflectionClass($class);
        $constructor = $reflectionClass->getConstructor();

        // If there is no constructor, simply create an instance
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

    /**
     *
     * @param object $controller
     * @param string $method
     * @return mixed
     */
    private function invokeMethod(object $controller, string $method)
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
?>
