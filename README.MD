## Annotations for JPHP
### Описание
Расширение позволяет использовать кастомные аннотации для классов, свойств и методов(как в Java)
### Установка
```
jppm add jphp-annotations-ext
```
### Примеры
#### Класс аннотации:
```php
namespace test\annotations;


class Route{
    public $path;
    private $methods = ['GET'];


    public function getMethods(): array{
        return $this->methods;
    }
    public function setMethods(array $methods){
        $this->methods = $methods;
    }
}
```
#### Определение аннотации для метода:
```php
namespace test\controllers;

use test\annotations\Route;

class SampleController{
    private $path;


    /**
     * @Route(path='/')
     */
    public function index(): void{
        echo "Hello, world!";
    }
    /**
     * @Route(path='/about')
     */
    public function about(): void{
        echo "http://vk.com/dn_extension";
    }
    /**
     * @Route(path='/login', methods=['GET', 'POST'])
     */
    public function login(): void{
        echo "he-he, not implemented :)";
    }
}
```
#### Использование аннотаций:
```php
use test\controllers\SampleController;
use test\annotations\Route;
use annotations\AnnotatedReflectionClass;

$class = new AnnotatedReflectionClass(SampleController::class);

foreach($class->getMethods() as $method){
    /** @var Route $route */
    $route = $class->getMethodAnnotationByClass($method->getName(), Route::class);
    if($route){
        echo "{$route->path} - ".str::join($route->getMethods(), ', ')."\n";
    }
}
```
#### Результат:
```
/ - GET
/about - GET
/login - GET, POST
```
## Дополнительно

[Venity](https://vk.com/venity)

[DevelNext - extensions & manuals.](https://vk.com/dn_extension)