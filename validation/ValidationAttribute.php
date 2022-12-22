<?php
namespace App\Src\Core\Validation;

class ValidationAttribute
{
    public string $message;

    public function __construct(string $message = "")
    {
        $this->message = $message;
    }
}