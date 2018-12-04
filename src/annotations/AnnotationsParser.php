<?php


namespace annotations;


use php\lib\arr;
use php\util\Regex;

class AnnotationsParser{
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
    /**
     * @var \ReflectionClass
     */
    private $reflection;

    private $methodsAnnotations = [];
    private $fieldsAnnotations = [];
    private $classAnnotations = [];


    public function __construct($class){
        $this->reflection = ($class instanceof \ReflectionClass) ? $class : new \ReflectionClass($class);
        if(!isset(self::$usagesByFile[$this->reflection->getFileName()])){
            self::$usagesByFile[$this->reflection->getFileName()] = new UsagesParser($this->reflection->getFileName());
            self::$usagesByFile[$this->reflection->getFileName()]->parse();
        }
        $this->usages = self::$usagesByFile[$this->reflection->getFileName()];
    }
    public function parse(): void{
        if($this->reflection->getDocComment()){
            $this->classAnnotations = $this->parseComment($this->reflection->getDocComment());
        }
        foreach($this->reflection->getProperties() as $property){
            if($property->getDocComment()){
                $this->fieldsAnnotations[$property->getName()] = $this->parseComment($property->getDocComment());
            }
        }
        foreach($this->reflection->getMethods() as $method){
            if($method->getDocComment()){
                $this->methodsAnnotations[$method->getName()] = $this->parseComment($method->getDocComment());
            }
        }
    }
    private function parseComment(string $doc): array{
        $result = [];

        // thx Dmitriy Zayceff :3
        // https://github.com/jphp-group/jphp/blob/master/packager/src-php/packager/Annotations.php#L137
        $regex = new Regex('\\@([a-z0-9\\-\\_\\\\]+)([ ]{0,}(.+))?', 'im', $doc);
        while($regex->find()){
            $groups = $regex->groups();
            $name = $groups[1];
            if(arr::has(self::$DEFAULT_DOC, $name)){
                continue;
            }
            $value = $groups[3];
            $class = $this->getClass($name);
            if(!$class){
                continue;
            }
            $parsedArgs = new ArgumentParser($value);
            $parsedArgs->parse();
            $namedArgs = $parsedArgs->getNamedArgs();
            $positionArgs = $parsedArgs->getPositionArgs();

            try{
                $reflection = new \ReflectionClass($class);
                $args = [];
                $constructor = $reflection->getConstructor();
                if($reflection->implementsInterface(Annotation::class)){
                    /** @var Annotation $annotation */
                    $annotation = $reflection->newInstanceWithoutConstructor();
                    $annotation->setProperties($positionArgs, $namedArgs);
                    if($constructor){
                        $constructor->invoke($annotation);
                    }
                    $result[$reflection->getName()] = $annotation;
                }
                else{
                    $hasArgs = [];
                    foreach($constructor->getParameters() as $i => $parameter){
                        if($hasArgs[$parameter->getPosition()]){
                            continue;
                        }
                        if(isset($positionArgs[$parameter->getPosition()])){
                            $args[$parameter->getPosition()] = $positionArgs[$parameter->getPosition()];
                        }
                        else if(isset($namedArgs[$parameter->getName()])){
                            $args[$parameter->getPosition()] = $namedArgs[$parameter->getName()];
                        }
                        else{
                            $args[$parameter->getPosition()] = $parameter->getDefaultValue();
                        }
                        $hasArgs[$parameter->getPosition()] = true;
                    }
                    $result[$reflection->getName()] = $reflection->newInstanceArgs($args);
                }
            }
            catch(\ReflectionException $e){
                throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
            }
        }
        return $result;
    }

    /**
     * @return array
     */
    public function getClassAnnotations(): array{
        return $this->classAnnotations;
    }
    /**
     * @param string $method
     * @return array
     */
    public function getMethodsAnnotations(?string $method = null): array{
        return isset($method) ? $this->methodsAnnotations[$method] : $this->methodsAnnotations;
    }
    /**
     * @param string $field
     * @return array
     */
    public function getFieldsAnnotations(?string $field = null): array{
        return isset($field) ? $this->fieldsAnnotations[$field] : $this->fieldsAnnotations;
    }

    public function getClassAnnotation(string $class){
        return $this->classAnnotations[$class];
    }
    public function getMethodAnnotation(string $method, string $class){
        return $this->methodsAnnotations[$method][$class];
    }
    public function getFieldAnnotation(string $field, string $class){
        return $this->fieldsAnnotations[$field][$class];
    }

    private function getClass(string $name): ?string{
        if(class_exists($name)){
            return $name;
        }
        if($this->usages->getName($name) !== null){
            return $this->usages->getName($name);
        }
        if(class_exists($this->reflection->getNamespaceName().'\\'.$name)){
            return $this->reflection->getNamespaceName().'\\'.$name;
        }
        return null;
    }

    /**
     * @return UsagesParser
     */
    public function getUsages(): UsagesParser{
        return $this->usages;
    }

    /**
     * @return \ReflectionClass
     */
    public function getReflection(): \ReflectionClass{
        return $this->reflection;
    }
}