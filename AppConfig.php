<?php
namespace App\Src\Core;

class AppConfig
{
    public readonly string $rootDir;
    public readonly string $defaultRoute;
    public readonly string $loginRoute;
    public readonly string $logoutRoute;
    private ?array $dbConfig;

    public function __construct(string $rootDir, string $defaultRoute, string $loginRoute, string $logoutRoute, array $dbConfig)
    {
        $this->rootDir = $rootDir;
        $this->defaultRoute = $defaultRoute;
        $this->loginRoute = $loginRoute;
        $this->logoutRoute = $logoutRoute;
        $this->dbConfig = $dbConfig;
    }

    public function getDbConfig()
    {
        $dbConfig = $this->dbConfig;
        $this->dbConfig = null;
        return $dbConfig;
    }
}