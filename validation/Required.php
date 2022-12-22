<?php
namespace App\Src\Core\Validation;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Required extends ValidationAttribute
{
    public function __construct($message = "This property is required!")
    {
        parent::__construct($message);
    }
}