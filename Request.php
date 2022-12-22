<?php
namespace App\Src\Core;

class Request
{
    public readonly string $method;
    public readonly string $uri;
    public readonly string $controller;
    public readonly string $route;
    private array $routeParams;

    public function __construct()
    {
        $this->uri = $this->getUri();
        $uriParts = explode("/", ltrim($this->uri, "/"));

        $this->method = $this->getMethod();
        $this->controller = ucwords(array_shift($uriParts)) . "Controller";
        $this->route = "/" . implode("/", $uriParts);
    }

    private function getMethod() : string
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    public function isGet()
    {
        return $this->method === "get";
    }

    public function isPost()
    {
        return $this->method === "post";
    }

    private function getUri() : string
    {
        $uri = $_SERVER["REQUEST_URI"];

        $position = strpos($uri, "?");

        if ($position === false)
            return $uri;

        return substr($uri, 0, $position);
    }

    public function setRouteParams($routeParams) : void
    {
        $this->routeParams = $routeParams;
    }

    public function getRouteParams() : array
    {
        return $this->routeParams;
    }
}