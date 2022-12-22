<?php

namespace App\Src\Core;

abstract class Controller
{
    private ?View $view = null;
    private array $middlewares = [];

    protected function render($params = [])
    {
        return $this->view->render($params);
    }

    protected function setView($view, $layout = "main") {
        if ($this->view === null) {
            $this->view = new View($view, $layout);
        } else {
            $this->view->setView($view);
            $this->view->setLayout($layout);
        }
    }

    public function executeMiddlewares()
    {
        foreach ($this->middlewares as $middleware) {
            $middleware->execute();
        }
    }

    protected function registerMiddleware($middleware)
    {
        $this->middlewares[] = $middleware;
    }
}
