<?php

namespace MiniMarkPlace\Libraries;

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
        $path   = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); 
        
        // Check for overridden methods (PUT, DELETE)
        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }
        
        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];
            
            if (is_callable($handler)) {
                return call_user_func($handler);
            } elseif (is_array($handler) && isset($handler[0]) && isset($handler[1])) {
                [$controllerClass, $methodName] = $handler;

                if (class_exists($controllerClass) && method_exists($controllerClass, $methodName)) {
                    $controller = new $controllerClass();
                    
                    return call_user_func([$controller, $methodName], new Request());
                } else {
                    throw new \Exception("Controller or method does not exist.");
                }
            }
        }
        
        return '404 Not Found';
    }
}
?>
