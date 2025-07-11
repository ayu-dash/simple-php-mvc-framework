<?php

namespace App\Core\Https;

use App\Core\Exceptions\RouteNotFoundException;

class Router {
    public $routes;
    private Request $request;
    private Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;    
    }

    public function get($route, $callback) {
        $this->routes['get'][$route] = $callback;
    }

    public function post($route, $callback) {
        $this->routes['post'][$route] = $callback;
    }

    public function put($route, $callback) {
        $this->routes['put'][$route] = $callback;   
    }

    public function delete($route, $callback) {
        $this->routes['delete'][$route] = $callback; 
    }

    public function dispatch() {
        $callback = $this->matchRoute() ?? $this->matchDynamicRoute() ?? $this->defaultRoute();

        if(!$callback) throw new RouteNotFoundException('Route "' . $this->request->getRoute() . '" doesnt exists');

        if(is_callable($callback)) {
            call_user_func($callback, $this->request, $this->response);
        } else if(is_array($callback) && class_exists($callback[0])) {
            $instance = new $callback[0];
            call_user_func([$instance, $callback[1]], $this->request, $this->response);
        }
    }   

    private function matchRoute() {
        $methodReq = $this->request->getMethod();
        $routeReq = $this->request->getRoute();
        return $this->routes[$methodReq][$routeReq] ?? null;
    }

    public function matchDynamicRoute() {
        $methodReq = $this->request->getMethod();
        $routeReq = $this->request->getRoute();

        foreach($this->routes[$methodReq] as $route => $callback) {
            if($route === '*') continue;

            // mendapatkan param dari route
            preg_match_all('/:([\w-]+)/', $route, $paramNames);
            $paramNames = $paramNames[1];
            
            if(!$paramNames) continue;

            $pattern = preg_replace('/:([\w-]+)/', '([^/]+)', $route);
            $pattern = "#^$pattern$#";

            if (preg_match($pattern, $routeReq, $matches)) {
                array_shift($matches);
                $params = array_combine($paramNames, $matches);
                $this->request->setParams($params);

                return $callback;
            }
        }

        return null;
    }

    private function defaultRoute() {
        $methodReq = $this->request->getMethod();

        // cek apakah ada route '*' 
        return $this->routes[$methodReq]['*'] ?? null;
    }
}