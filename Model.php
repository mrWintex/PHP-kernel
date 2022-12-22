<?php
namespace App\Src\Core;

use App\Src\Core\Validation\{Future, MatchProp, Max, Required, Min};
use ReflectionClass;

class Model
{
    private array $errors = [];

    protected function validate(object $entity): bool
    {
        $reflection = new ReflectionClass($entity);

        foreach ($reflection->getProperties() as $property) {
            if ($attr = $property->getAttributes(Required::class)[0] ?? null) {
                $attr = $attr->newInstance();
                if (empty(strval($property->getValue($entity)))) {
                    $this->addError($property->getName(), $attr->message);
                }
            }
            if ($attr = $property->getAttributes(Min::class)[0] ?? null) {
                $value = $property->getValue($entity);
                $attr = $attr->newInstance();

                if (($property->getType()->getName() === "string" && strlen(strval($value)) < $attr->min) || ($property->getType()->getName() === "int" && intval($value) < $attr->min)) {
                    $this->addError($property->getName(), $attr->message);
                }
            }
            if ($attr = $property->getAttributes(Max::class)[0] ?? null) {
                $value = $property->getValue($entity);
                $attr = $attr->newInstance();

                if ($property->getType()->getName() === "string" && strlen(strval($value)) > $attr->max || ($property->getType()->getName() === "int" && $value > $attr->max)) {
                    $this->addError($property->getName(), $attr->message);
                }
            }
            if ($attr = $property->getAttributes(MatchProp::class)[0] ?? null) {
                $value = $property->getValue($entity);
                $attr = $attr->newInstance();

                if ($value !== $reflection->getProperty($attr->property)->getValue($entity)) {
                    $this->addError($property->getName(), $attr->message);
                }
            }
            if ($attr = $property->getAttributes(Future::class)[0] ?? null) {
                $value = $property->getValue($entity);
                $attr = $attr->newInstance();

                if (strtotime($value) <= strtotime(date("d-m-Y"))) {
                    $this->addError($property->getName(), $attr->message);
                }
            }
        }
        return false;
    }

    public function addError($property, $error): void
    {
        $this->errors[$property][] = $error;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function error(): bool
    {
        return count($this->errors) !== 0;
    }
}