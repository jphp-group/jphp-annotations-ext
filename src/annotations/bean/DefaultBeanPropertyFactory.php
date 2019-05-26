<?php


namespace annotations\bean;



use php\lang\IllegalArgumentException;
use php\lib\str;

class DefaultBeanPropertyFactory implements BeanPropertyFactory{
    /**
     * @param \ReflectionProperty $property
     * @param $object
     * @param $value
     * @throws IllegalArgumentException
     * @throws \ReflectionException
     */
    public function setProperty(\ReflectionProperty $property, $object, $value): void{
        $method = $this->getMethod('set', $property);
        if(!$property->isPublic() && !$method){
            throw new IllegalArgumentException("Unable to find public setter for {$property->getName()} property");
        }
        if($method){
            $method->invokeArgs($object, [$value]);
        }
        else{
            $property->setValue($object, $value);
        }
    }

    /**
     * @param \ReflectionProperty $property
     * @param $object
     * @return mixed
     * @throws IllegalArgumentException
     * @throws \ReflectionException
     */
    public function getProperty(\ReflectionProperty $property, $object){
        $method = $this->getMethod('get', $property);
        if(!$property->isPublic() && !$method){
            throw new IllegalArgumentException("Unable to find public getter for {$property->getName()} property");
        }
        if($method){
            return $method->invokeArgs($object, []);
        }
        else{
            return $property->getValue($object);
        }
    }

    /**
     * @param string $prefix
     * @param \ReflectionProperty $property
     * @return \ReflectionMethod|null
     * @throws \ReflectionException
     */
    private function getMethod(string $prefix, \ReflectionProperty $property): ?\ReflectionMethod{
        $name = $prefix.str::upperFirst($property->getName());
        $class = $property->getDeclaringClass();
        if(!$class->hasMethod($name)){
            return null;
        }
        $method = $class->getMethod($name);
        if($method->isPrivate()){
            return null;
        }

        return $method;
    }
}