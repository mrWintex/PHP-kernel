<?php
namespace App\Src\Core\Validation;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Max extends ValidationAttribute
{
    public int $max;

    public function __construct($message = "This property is too long!", $max = 20)
    {
        $this->max = $max;
        parent::__construct($message);
    }
}