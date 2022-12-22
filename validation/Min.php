<?php
namespace App\Src\Core\Validation;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Min extends ValidationAttribute
{
    public int $min;

    public function __construct(string $message = "This property should be grater then {min}", int $min = 3)
    {
        $message = str_replace("{min}", $min, $message);
        $this->min = $min;
        parent::__construct($message);
    }
}