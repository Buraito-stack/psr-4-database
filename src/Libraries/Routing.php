<?php

namespace MiniMarkPlace\Libraries;

class Routing
{
    private array $routes = [];

    /**
     * Add a route to the routing table.
     *
     * @param string $method  
     * @param string $path     
     * @param callable|array  
     * @return void
     */
    public function add(string $method, string $path, $handler): void
    {
        $this->routes[$method][$path] = $handler;
    }

    /**
     * Run the route handler based on the current request method and path.
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
            } elseif (is_array($handler) && isset($handler[0]) && isset($handler[1])) {
                [$controllerClass, $methodName] = $handler;
                
                if (class_exists($controllerClass) && method_exists($controllerClass, $methodName)) {
                    $controller = new $controllerClass();
                    return call_user_func([$controller, $methodName]);
                } else {
                    throw new \Exception("Controller or method does not exist.");
                }
            }
        }
        
        return '404 Not Found';
    }
}
?>
