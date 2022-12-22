<?php
namespace App\Src\Core;

class View
{
    private ?string $layout;
    private string $view;

    public function __construct(string $view, ?string $layout = "main")
    {
        $this->view = $view;
        $this->layout = $layout;
    }

    public function render(array $params = []) : string
    {
        if ($this->layout != null) {
            return $this->renderWithLayout($params);
        }
        return $this->renderView($params);
    }

    private function renderView($params) : string
    {
        ob_start();
        extract($params);
        include(Application::$config->rootDir . "/src/views/" . $this->view . ".phtml");
        return ob_get_clean();
    }

    private function renderWithLayout($params) : string
    {
        ob_start();
        include(Application::$config->rootDir . "/src/views/layouts/" . $this->layout . ".phtml");
        $layout = ob_get_clean();
        $view = $this->renderView($params);

        return str_replace("{{content}}", $view, $layout);
    }

    public function setView(string $view) : void
    {
        $this->view = $view;
    }

    public function setLayout(?string $layout) : void
    {
        $this->layout = $layout;
    }

    public static function errorView() : View
    {
        return new View("_404", null);
    }
}