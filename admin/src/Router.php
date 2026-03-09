<?php
namespace App;

class Router
{
    private $routes = [];

    public function addRoute($pattern, $callback)
    {
        $this->routes[$pattern] = $callback;
    }

    public function match($uri) {
    foreach ($this->routes as $pattern => $handler) {
        
        if (preg_match($pattern, $uri, $matches)) {
            
            array_shift($matches);
            
            return call_user_func_array($handler, $matches);
        }
    }
    
    throw new \Exception("No route found for URI: " . $uri);
    }
}
