<?php
namespace MiniMarkPlace\Libraries;

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
        $request = new Request();
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
                    $controller = new $controllerClass;
                    $reflectionMethod = new ReflectionMethod($controller, $methodName);

                    $params = [];
                    $hasRequest = false;

                    foreach ($reflectionMethod->getParameters() as $parameter) {
                        $paramType = $parameter->getType();

                        if ($paramType && $paramType->getName() === Request::class) {
                            $hasRequest = true;
                        } else {
                            $params[] = null; 
                        }
                    }

                    if ($hasRequest) {
                        array_unshift($params, $request);
                    }

                    return $reflectionMethod->invokeArgs($controller, $params);
                }

                throw new Exception("Controller or method does not exist.");
            }
        }

        header('HTTP/1.1 404 Not Found');
        die('404 Not Found');
    }
}
?>
