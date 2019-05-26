<?php


namespace annotations;


use annotations\bean\BeanPropertyFactory;
use annotations\bean\DefaultBeanPropertyFactory;
use php\lang\IllegalArgumentException;
use php\lib\arr;
use php\util\Regex;
use php\util\RegexException;

class AnnotatedReflectionClass extends \ReflectionClass{
    private static $DEFAULT_DOC = ['example', 'internal', 'inheritdoc', 'link', 'see', 'api', 'author', 'category',
        'copyright', 'deprecated', 'filesource', 'global', 'ignore', 'internal',
        'license', 'link', 'method', 'package', 'param', 'property', 'property-read', 'property-write',
        'return', 'see', 'since', 'source', 'subpackage', 'throws', 'todo', 'uses', 'used-by', 'var', 'versions'];
    /**
     * @var UsagesParser[]
     */
    private static $usagesByFile = [];

    /**
     * @var UsagesParser
     */
    private $usages;

    private $methodsAnnotations = [];
    private $fieldsAnnotations = [];
    private $classAnnotations = [];

    private $methodDocAnnotations = [];
    private $fieldsDocAnnotations = [];
    private $classDocAnnotations = [];

    private $allowNoneExistsProperties = false;
    /**
     * @var BeanPropertyFactory|null
     */
    private $beanPropertyFactory;



    /**
     * AnnotatedReflectionClass constructor.
     * @param $class
     * @throws \ReflectionException
     */
    public function __construct($class){
        parent::__construct($class);
        if(!isset(self::$usagesByFile[$this->getFileName()])){
            self::$usagesByFile[$this->getFileName()] = new UsagesParser($this->getFileName());
            self::$usagesByFile[$this->getFileName()]->parse();
        }
        $this->usages = self::$usagesByFile[$this->getFileName()];
        $this->beanPropertyFactory = new DefaultBeanPropertyFactory();
        $this->parse();
    }

    /**
     * @return BeanPropertyFactory|null
     */
    public function getBeanPropertyFactory(): ?BeanPropertyFactory{
        return $this->beanPropertyFactory;
    }
    /**
     * @param BeanPropertyFactory|null $beanPropertyFactory
     */
    public function setBeanPropertyFactory(?BeanPropertyFactory $beanPropertyFactory): void{
        $this->beanPropertyFactory = $beanPropertyFactory;
    }


    /**
     * @return bool
     */
    public function isAllowNoneExistsProperties(): bool{
        return $this->allowNoneExistsProperties;
    }
    /**
     * @param bool $allowNoneExistsProperties
     */
    public function setAllowNoneExistsProperties(bool $allowNoneExistsProperties): void{
        $this->allowNoneExistsProperties = $allowNoneExistsProperties;
    }

    private function parse(): void{
        if($this->getDocComment()){
            $this->classAnnotations = $this->parseComment($this->getDocComment(), $this->classDocAnnotations);
        }
        foreach($this->getProperties() as $property){
            if($property->getDocComment()){
                $this->fieldsAnnotations[$property->getName()] = $this->parseComment($property->getDocComment(), $this->fieldsDocAnnotations);
            }
        }
        foreach($this->getMethods() as $method){
            if($method->getDocComment()){
                $this->methodsAnnotations[$method->getName()] = $this->parseComment($method->getDocComment(), $this->methodDocAnnotations);
            }
        }
    }
    private function parseComment(string $doc, &$docArray): array{
        $result = [];

        // thx Dmitriy Zayceff :3
        // https://github.com/jphp-group/jphp/blob/master/packager/src-php/packager/Annotations.php#L137
        $regex = new Regex('\\@([a-z0-9\\-\\_\\\\]+)([ ]{0,}(.+))?', 'im', $doc);

        $argumentParser = new ArgumentParser();

        try{
            while($regex->find()){
                $groups = $regex->groups();
                $name = $groups[1];
                $value = $groups[3];
                if(arr::has(self::$DEFAULT_DOC, $name)){
                    if(!$docArray[$name]){
                        $docArray[$name] = [];
                    }
                    $docArray[$name][] = $value;
                    continue;
                }

                $class = $this->getClass($name);
                if(!$class){
                    continue;
                }
                $args = $argumentParser->parse($value);

                $reflection = new \ReflectionClass($class);
                $constructor = $reflection->getConstructor();

                $object = $reflection->newInstanceWithoutConstructor();

                foreach($args as $fieldName => $arg){
                    if(!$reflection->hasProperty($fieldName)){
                        if(!$this->allowNoneExistsProperties){
                            throw new IllegalArgumentException("Property {$fieldName} does not exists in {$reflection->getName()}");
                        }
                        else{
                            $object->{$fieldName} = $arg;
                        }
                    }
                    else{
                        $property = $reflection->getProperty($fieldName);
                        if($this->beanPropertyFactory){
                            $this->beanPropertyFactory->setProperty($property, $object, $arg);
                        }
                        else{
                            // not safe
                            $property->setValue($object, $arg);
                        }
                    }
                }

                if(!$result[$reflection->getName()]){
                    $result[$reflection->getName()] = [];
                }
                if($constructor){
                    $constructor->invoke($object);
                }

                $result[$reflection->getName()][] = $object;
            }
        }
        catch(\ReflectionException|RegexException|IllegalArgumentException $e){
            throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
        }


        return $result;
    }


    public function getAnnotations(){
        return $this->classAnnotations;
    }
    public function getAnnotationByClass(string $className){
        return arr::first($this->classAnnotations[$className] ?? []);
    }
    public function getAnnotationsByClass(string $className){
        return $this->classAnnotations[$className];
    }


    public function getMethodAnnotations(){
        return $this->methodsAnnotations;
    }
    public function getMethodAnnotationsByName(string $methodName){
        return $this->methodsAnnotations[$methodName];
    }
    public function getMethodAnnotationByClass(string $methodName, string $className){
        return arr::first($this->methodsAnnotations[$methodName][$className] ?? []);
    }
    public function getMethodAnnotationsByClass(string $methodName, string $className){
        return $this->methodsAnnotations[$methodName][$className];
    }


    public function getFieldAnnotations(){
        return $this->fieldsAnnotations;
    }
    public function getFieldAnnotationsByName(string $fieldName){
        return $this->fieldsAnnotations[$fieldName];
    }
    public function getFieldAnnotationByClass(string $fieldName, string $className){
        return arr::first($this->fieldsAnnotations[$fieldName][$className] ?? []);
    }
    public function getFieldAnnotationsByClass(string $fieldName, string $className){
        return $this->fieldsAnnotations[$fieldName][$className];
    }


    public function getDocAnnotations(){
        return $this->classDocAnnotations;
    }
    public function getDocAnnotationByName(string $name){
        return arr::first($this->classDocAnnotations[$name] ?? []);
    }
    public function getDocAnnotationsByName(string $name){
        return $this->classDocAnnotations[$name];
    }

    public function getMethodDocAnnotations(){
        return $this->methodDocAnnotations;
    }
    public function getMethodDocAnnotationByName(string $methodName, string $name){
        return arr::first($this->methodDocAnnotations[$methodName][$name] ?? []);
    }
    public function getMethodDocAnnotationsByName(string $methodName, string $name){
        return $this->methodDocAnnotations[$methodName][$name];
    }

    public function getFieldDocAnnotations(){
        return $this->fieldsDocAnnotations;
    }
    public function getFieldDocAnnotationByName(string $fieldName, string $name){
        return arr::first($this->fieldsDocAnnotations[$fieldName][$name] ?? []);
    }
    public function getFieldDocAnnotationsByName(string $fieldName, string $name){
        return $this->fieldsDocAnnotations[$fieldName][$name];
    }


    private function getClass(string $name): ?string{
        if(class_exists($name)){
            return $name;
        }
        if($this->usages->getName($name) !== null){
            return $this->usages->getName($name);
        }
        if(class_exists($this->getNamespaceName().'\\'.$name)){
            return $this->getNamespaceName().'\\'.$name;
        }
        return null;
    }

    /**
     * @return UsagesParser
     */
    public function getUsages(): UsagesParser{
        return $this->usages;
    }
}