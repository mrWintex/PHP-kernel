<?php

namespace App\Src\Core;

use App\Src\Core\Db\Db;
use App\Src\Core\Exception\ExceptionHandler;
use ReflectionClass;
use ReflectionParameter;

class Application
{
    public static ?AppConfig $config = null;
    private DIContainer $container;
    private Router $router;
    private Request $request;

    private ?Controller $controller = null;
    public static ?string $controllerName = null;
    public static ?string $routeName = null;

    public function __construct(AppConfig $config)
    {
        static::$config = $config;
        $this->container = new DIContainer();

        $handler = new ExceptionHandler();
        $database = new Db();
        $database->Connect($config->getDbConfig());

        $this->container->registerDependency($this);
        $this->container->registerDependency($database);
        $this->container->registerDependency($handler);
        $this->request = $this->container->getDependency(Request::class);
        $this->router = $this->container->getDependency(Router::class);
    }

    public function run(): string
    {
        $this->router->resolve(static::$controllerName, static::$routeName);
        return $this->runController();
    }

    public function runController()
    {
        $this->controller = $this->container->getDependency(static::$controllerName);
        $this->controller->executeMiddlewares();
        return call_user_func([$this->controller, static::$routeName], ...$this->getRouteMethodParams());
    }

    private function getRouteMethodParams(): array
    {
        $routeMethodParams = [];
        $reflection = new ReflectionClass(get_class($this->controller));
        $parameters = $reflection->getMethod(static::$routeName)->getParameters();

        foreach ($parameters as $parameter) {
            $routeMethodParams[] = $this->getRouteMethodParam($parameter);
        }

        return $routeMethodParams;
    }

    private function getRouteMethodParam(ReflectionParameter $parameter)
    {
        if (!$parameter->hasType()) return null;
        $paramType = $parameter->getType();
        if ($paramType->isBuiltin()) {
            if ($paramType->getName() === "string")
                return strval($this->request->getRouteParams()[$parameter->getName()] ?? "");
            else if ($paramType->getName() === "int")
                return intval($this->request->getRouteParams()[$parameter->getName()] ?? 0);
            else
                return null;
        }

        return $this->container->getDependency($paramType->getName());
    }
}
