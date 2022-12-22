<?php
namespace App\Src\Core;

use ReflectionClass;

class DIContainer
{
    private array $dependencies = [];
    private array $definitions = [];

    public function registerDependency(object $dependency) : void
    {
        $key = get_class($dependency);
        $this->dependencies[$key] = $dependency;
    }

    public function getDependency(string $class) : object
    {
        if (!isset($this->dependencies[$class])) {
            $class_name = $this->definitions[$class] ?? $class;
            $instance = new $class_name;

            $this->dependencies[$class] = $instance;
            $reflex = new ReflectionClass($instance);
            $this->injectDependencies($reflex, $instance);
            return $instance;
        }
        return $this->dependencies[$class];
    }

    public function injectDependencies(ReflectionClass $reflex, $instance) : void
    {
        $propeties = $reflex->getProperties();
        foreach($propeties as $prop){
            $attrs = $prop->getAttributes(Inject::class);

            if(isset($attrs[0])){
                $class_name = $prop->hasType() ?
                    strval($prop->getType()) :
                    $attrs[0]->newInstance()->getClassName();

                $prop->setValue($instance, $this->getDependency($class_name));
            }
        }
    }

    public function define($class, $definition) : void
    {
        $this->definitions[$class] = $definition;
    }
}
