<?php

namespace MiniMarkPlace\Libraries;

use ReflectionClass;
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
                    $controller = new $controllerClass();
                    $reflection = new ReflectionClass($controller);
                    $methodParams = $reflection->getMethod($methodName)->getParameters();
                    $params = [];

                    foreach ($methodParams as $parameter) {
                        $paramType = $parameter->getType();

                        if ($paramType && $paramType->getName() === Request::class) {
                            $params[] = new Request();
                        }
                    }

                    return $reflection->getMethod($methodName)->invokeArgs($controller, $params);
                }

                throw new Exception("Controller or method does not exist.");
            }
        }

        return '404 Not Found';
    }
}
