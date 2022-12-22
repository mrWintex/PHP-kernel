<?php

namespace App\Src\Core;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Inject
{
    private string $className;

    public function __construct($className = "")
    {
        $this->className = $className;
    }

    public function getClassName()
    {
        return $this->className;
    }
}
