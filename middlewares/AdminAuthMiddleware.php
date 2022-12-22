<?php
namespace App\Src\Core\Middlewares;

use App\Src\Core\Application;
use App\Src\Core\Exception\NotFoundException;
use App\Src\Core\Utils\UserUtils;

class AdminAuthMiddleware implements Middleware
{
    private array $routes;

    public function __construct(string ...$routes)
    {
        $this->routes = $routes;
    }

    public function execute()
    {
        if (!UserUtils::isLogedInAdmin() && (in_array(Application::$routeName, $this->routes) || count($this->routes) === 0)) {
            throw new NotFoundException("User is not logged in!");
        }
    }
}