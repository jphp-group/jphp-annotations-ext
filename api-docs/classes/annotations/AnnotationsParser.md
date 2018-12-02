# AnnotationsParser

- **class** `AnnotationsParser` (`annotations\AnnotationsParser`)
- **source** `annotations/AnnotationsParser.php`

---

#### Properties

- `->`[`usagesByFile`](#prop-usagesbyfile) : `UsagesParser[]`
- `->`[`usages`](#prop-usages) : [`UsagesParser`](classes/annotations/UsagesParser.md)
- `->`[`reflection`](#prop-reflection) : `\ReflectionClass`
- `->`[`methodsAnnotations`](#prop-methodsannotations) : `mixed`
- `->`[`fieldsAnnotations`](#prop-fieldsannotations) : `mixed`
- `->`[`classAnnotations`](#prop-classannotations) : `mixed`

---

#### Methods

- `->`[`__construct()`](#method-__construct)
- `->`[`parse()`](#method-parse)
- `->`[`parseComment()`](#method-parsecomment)
- `->`[`getClassAnnotations()`](#method-getclassannotations)
- `->`[`getMethodsAnnotations()`](#method-getmethodsannotations)
- `->`[`getFieldsAnnotations()`](#method-getfieldsannotations)
- `->`[`getClassAnnotation()`](#method-getclassannotation)
- `->`[`getMethodAnnotation()`](#method-getmethodannotation)
- `->`[`getFieldAnnotation()`](#method-getfieldannotation)
- `->`[`getClass()`](#method-getclass)
- `->`[`getUsages()`](#method-getusages)
- `->`[`getReflection()`](#method-getreflection)

---
# Methods

<a name="method-__construct"></a>

### __construct()
```php
__construct(mixed $class): void
```

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
parseComment(string $doc): array
```

---

<a name="method-getclassannotations"></a>

### getClassAnnotations()
```php
getClassAnnotations(): array
```

---

<a name="method-getmethodsannotations"></a>

### getMethodsAnnotations()
```php
getMethodsAnnotations([ string $method): array
```

---

<a name="method-getfieldsannotations"></a>

### getFieldsAnnotations()
```php
getFieldsAnnotations([ string $field): array
```

---

<a name="method-getclassannotation"></a>

### getClassAnnotation()
```php
getClassAnnotation(string $class): void
```

---

<a name="method-getmethodannotation"></a>

### getMethodAnnotation()
```php
getMethodAnnotation(string $method, string $class): void
```

---

<a name="method-getfieldannotation"></a>

### getFieldAnnotation()
```php
getFieldAnnotation(string $field, string $class): void
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

---

<a name="method-getreflection"></a>

### getReflection()
```php
getReflection(): ReflectionClass
```