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
    private $path;


    public function __construct(string $path){
        $this->path = $path;
    }
    public function getPath(): string{
        return $this->path;
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
}
```
#### Использование аннотаций:
```php
use test\controllers\SampleController;
use test\annotations\Route;
use annotations\AnnotationsParser;

$class = new ReflectionClass(SampleController::class);
$parser = new AnnotationsParser($class);
$parser->parse();

foreach($class->getMethods() as $method){
    /** @var Route $route */
    $route = $parser->getMethodAnnotation($method->getName(), Route::class);
    if($route){
        var_dump($route->getPath());
    }
}
```
#### Результат:
```
string(1) "/"
string(6) "/about"
```
## Дополнительно

[Venity](https://vk.com/venity)

[DevelNext - extensions & manuals.](https://vk.com/dn_extension)