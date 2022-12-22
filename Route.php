<?php
namespace App\Src\Core;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Route {
    private string $path;
    private array $method;

    public function __construct($path = "/", $method = ["get"])
    {
        $this->path = $path;
        $this->method = $method;
    }
    
    public function getPath() : string
    {
        return $this->path;
    }
    
    public function getMethod() : array
    {
        return $this->method;
    }
}