<?php
namespace App\Src\Core\Validation;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class MatchProp extends ValidationAttribute
{
    public string $property;

    public function __construct($message = "Property should match with {property}", $property = "")
    {
        $message = str_replace("{property}", $property, $message);
        $this->property = $property;
        parent::__construct($message);
    }
}