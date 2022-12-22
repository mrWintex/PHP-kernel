<?php
namespace App\Src\Core\Validation;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Future extends ValidationAttribute
{
    public function __construct($message = "Date must be future")
    {
        parent::__construct($message);
    }
}