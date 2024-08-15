<?php

namespace MiniMarkPlace\Libraries;

class Routing
{
    private $routes = [];

    public function add($method, $path, $handler)
    {
        $this->routes[$method][$path] = $handler;
    }

    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $_SERVER['REQUEST_URI'];
    
        // Handle default case for root and avoid querying unnecessary paths
        if ($path === '/') {
            $path = '/';
        }
    
        // Check for overridden methods (PUT, DELETE)
        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }
    
        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];
            if (is_callable($handler)) {
                return call_user_func($handler);
            } elseif (is_array($handler) && isset($handler[0]) && isset($handler[1])) {
                $controller = new $handler[0]();
                return call_user_func([$controller, $handler[1]]);
            }
        }
    
        return '404 Not Found';
    }
}
