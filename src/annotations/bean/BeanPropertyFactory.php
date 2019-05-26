<?php


namespace annotations\bean;


interface BeanPropertyFactory{
    public function setProperty(\ReflectionProperty $property, $object, $value): void;
    public function getProperty(\ReflectionProperty $property, $object);
}