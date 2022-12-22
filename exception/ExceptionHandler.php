<?php
namespace App\Src\Core\Exception;

use App\Src\Core\Application;
use App\Src\Core\Router;
use App\Src\Core\View;
use Exception;

class ExceptionHandler
{
    public function __construct()
    {
        set_exception_handler([$this, "handleExceptions"]);
    }

    function handleExceptions(\Throwable $exception)
    {
        if ($exception instanceof NotFoundException) {
            echo View::errorView()->render();
            http_response_code(404);
            die;
        } else if ($exception instanceof UnauthorizedException) {
            Router::redirect(Application::$config->loginRoute);
            die;
        } else {
            http_response_code(500);
            throw $exception;
        }
    }
}