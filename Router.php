<?php

namespace App\Src\Core;

use App\Src\Core\Exception\NotFoundException;
use Exception;
use ReflectionClass;

class Router
{
    #[Inject]
    private Request $request;

    public function resolve(?string &$controller, ?string &$routeName)
    {
        if ($this->request->uri === "/") {
            static::redirect(Application::$config->defaultRoute);
        }
        
        //checking if controller exists
        if (file_exists(Application::$config->rootDir . "/src/controllers/". $this->request->controller .".php")) {
            //creating controller
            $controllerName = "App\\Src\\Controllers\\" . $this->request->controller;
            $reflectionClass = new ReflectionClass($controllerName);
            
            //looping through all controller routes
            foreach ($reflectionClass->getMethods() as $controllerMethod) {
                if (isset($controllerMethod->getAttributes(Route::class)[0])) {
                    $route = $controllerMethod->getAttributes(Route::class)[0]?->newInstance();

                    //checking current request method for this route
                    if (!in_array($this->request->method, $route->getMethod()))
                        continue;
                    
                    //testing regex pattern if this route matches the requested route and getting route parameters
                    $routeRegex = "@^" . preg_replace_callback("/{(\w+)}/", fn($m) => isset($m[1]) ? "(?P<{$m[1]}>.+)" : "", $route->getPath()) . "$@";
                    if (!preg_match_all($routeRegex, $this->request->route, $routeParams)) 
                        continue;

                    $this->request->setRouteParams($this->simplifyRouteParams($routeParams));
                    $controller = $controllerName;
                    $routeName = $controllerMethod->getName();
                    return;
                }
            }
        }
        throw new NotFoundException("Route not found!");
    }

    private function simplifyRouteParams($routeParams) : array
    {
        $newRouteParams = [];
        foreach ($routeParams as $key => $routeParam) {
            if (is_string($key)) {
                $newRouteParams[$key] = $routeParam[0];
            }
        }
        return $newRouteParams;
    }

    public static function redirect(string $path)
    {
        header("Location: $path");
        header("connection: closed");
        exit;
    }
}
