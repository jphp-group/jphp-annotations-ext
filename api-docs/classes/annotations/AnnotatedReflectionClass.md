# AnnotatedReflectionClass

- **class** `AnnotatedReflectionClass` (`annotations\AnnotatedReflectionClass`) **extends** `ReflectionClass` (`ReflectionClass`)
- **source** `annotations/AnnotatedReflectionClass.php`

---

#### Properties

- `->`[`DEFAULT_DOC`](#prop-default_doc) : `mixed`
- `->`[`usagesByFile`](#prop-usagesbyfile) : `UsagesParser[]`
- `->`[`usages`](#prop-usages) : [`UsagesParser`](https://github.com/jphp-group/jphp-annotations-ext/blob/master/api-docs/classes/annotations/UsagesParser.md)
- `->`[`methodsAnnotations`](#prop-methodsannotations) : `mixed`
- `->`[`fieldsAnnotations`](#prop-fieldsannotations) : `mixed`
- `->`[`classAnnotations`](#prop-classannotations) : `mixed`
- `->`[`methodDocAnnotations`](#prop-methoddocannotations) : `mixed`
- `->`[`fieldsDocAnnotations`](#prop-fieldsdocannotations) : `mixed`
- `->`[`classDocAnnotations`](#prop-classdocannotations) : `mixed`

---

#### Methods

- `->`[`__construct()`](#method-__construct) - _AnnotatedReflectionClass constructor._
- `->`[`parse()`](#method-parse)
- `->`[`parseComment()`](#method-parsecomment)
- `->`[`getAnnotations()`](#method-getannotations)
- `->`[`getAnnotationByClass()`](#method-getannotationbyclass)
- `->`[`getAnnotationsByClass()`](#method-getannotationsbyclass)
- `->`[`getMethodAnnotations()`](#method-getmethodannotations)
- `->`[`getMethodAnnotationsByName()`](#method-getmethodannotationsbyname)
- `->`[`getMethodAnnotationByClass()`](#method-getmethodannotationbyclass)
- `->`[`getMethodAnnotationsByClass()`](#method-getmethodannotationsbyclass)
- `->`[`getFieldAnnotations()`](#method-getfieldannotations)
- `->`[`getFieldAnnotationsByName()`](#method-getfieldannotationsbyname)
- `->`[`getFieldAnnotationByClass()`](#method-getfieldannotationbyclass)
- `->`[`getFieldAnnotationsByClass()`](#method-getfieldannotationsbyclass)
- `->`[`getDocAnnotations()`](#method-getdocannotations)
- `->`[`getDocAnnotationByName()`](#method-getdocannotationbyname)
- `->`[`getDocAnnotationsByName()`](#method-getdocannotationsbyname)
- `->`[`getMethodDocAnnotations()`](#method-getmethoddocannotations)
- `->`[`getMethodDocAnnotationByName()`](#method-getmethoddocannotationbyname)
- `->`[`getMethodDocAnnotationsByName()`](#method-getmethoddocannotationsbyname)
- `->`[`getFieldDocAnnotations()`](#method-getfielddocannotations)
- `->`[`getFieldDocAnnotationByName()`](#method-getfielddocannotationbyname)
- `->`[`getFieldDocAnnotationsByName()`](#method-getfielddocannotationsbyname)
- `->`[`getClass()`](#method-getclass)
- `->`[`getUsages()`](#method-getusages)

---
# Methods

<a name="method-__construct"></a>

### __construct()
```php
__construct(mixed $class): void
```
AnnotatedReflectionClass constructor.

---

<a name="method-parse"></a>

### parse()
```php
parse(): void
```

---

<a name="method-parsecomment"></a>

### parseComment()
```php
parseComment(string $doc, mixed $docArray): array
```

---

<a name="method-getannotations"></a>

### getAnnotations()
```php
getAnnotations(): void
```

---

<a name="method-getannotationbyclass"></a>

### getAnnotationByClass()
```php
getAnnotationByClass(string $className): void
```

---

<a name="method-getannotationsbyclass"></a>

### getAnnotationsByClass()
```php
getAnnotationsByClass(string $className): void
```

---

<a name="method-getmethodannotations"></a>

### getMethodAnnotations()
```php
getMethodAnnotations(): void
```

---

<a name="method-getmethodannotationsbyname"></a>

### getMethodAnnotationsByName()
```php
getMethodAnnotationsByName(string $methodName): void
```

---

<a name="method-getmethodannotationbyclass"></a>

### getMethodAnnotationByClass()
```php
getMethodAnnotationByClass(string $methodName, string $className): void
```

---

<a name="method-getmethodannotationsbyclass"></a>

### getMethodAnnotationsByClass()
```php
getMethodAnnotationsByClass(string $methodName, string $className): void
```

---

<a name="method-getfieldannotations"></a>

### getFieldAnnotations()
```php
getFieldAnnotations(): void
```

---

<a name="method-getfieldannotationsbyname"></a>

### getFieldAnnotationsByName()
```php
getFieldAnnotationsByName(string $fieldName): void
```

---

<a name="method-getfieldannotationbyclass"></a>

### getFieldAnnotationByClass()
```php
getFieldAnnotationByClass(string $fieldName, string $className): void
```

---

<a name="method-getfieldannotationsbyclass"></a>

### getFieldAnnotationsByClass()
```php
getFieldAnnotationsByClass(string $fieldName, string $className): void
```

---

<a name="method-getdocannotations"></a>

### getDocAnnotations()
```php
getDocAnnotations(): void
```

---

<a name="method-getdocannotationbyname"></a>

### getDocAnnotationByName()
```php
getDocAnnotationByName(string $name): void
```

---

<a name="method-getdocannotationsbyname"></a>

### getDocAnnotationsByName()
```php
getDocAnnotationsByName(string $name): void
```

---

<a name="method-getmethoddocannotations"></a>

### getMethodDocAnnotations()
```php
getMethodDocAnnotations(): void
```

---

<a name="method-getmethoddocannotationbyname"></a>

### getMethodDocAnnotationByName()
```php
getMethodDocAnnotationByName(string $methodName, string $name): void
```

---

<a name="method-getmethoddocannotationsbyname"></a>

### getMethodDocAnnotationsByName()
```php
getMethodDocAnnotationsByName(string $methodName, string $name): void
```

---

<a name="method-getfielddocannotations"></a>

### getFieldDocAnnotations()
```php
getFieldDocAnnotations(): void
```

---

<a name="method-getfielddocannotationbyname"></a>

### getFieldDocAnnotationByName()
```php
getFieldDocAnnotationByName(string $fieldName, string $name): void
```

---

<a name="method-getfielddocannotationsbyname"></a>

### getFieldDocAnnotationsByName()
```php
getFieldDocAnnotationsByName(string $fieldName, string $name): void
```

---

<a name="method-getclass"></a>

### getClass()
```php
getClass(string $name): string
```

---

<a name="method-getusages"></a>

### getUsages()
```php
getUsages(): annotations\UsagesParser
```