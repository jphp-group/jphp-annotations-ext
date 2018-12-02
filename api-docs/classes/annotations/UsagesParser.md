# UsagesParser

- **class** `UsagesParser` (`annotations\UsagesParser`)
- **source** `annotations/UsagesParser.php`

---

#### Properties

- `->`[`usages`](#prop-usages) : `array`
- `->`[`usagesAliases`](#prop-usagesaliases) : `array`
- `->`[`useStatementsParsed`](#prop-usestatementsparsed) : `boolean`
- `->`[`tokenizer`](#prop-tokenizer) : `SourceTokenizer`
- `->`[`source`](#prop-source) : `string`

---

#### Methods

- `->`[`__construct()`](#method-__construct) - _UsagesParser constructor._
- `->`[`parse()`](#method-parse)
- `->`[`tokenizeSource()`](#method-tokenizesource)
- `->`[`store()`](#method-store)
- `->`[`storeAlias()`](#method-storealias)
- `->`[`getSimpleClassName()`](#method-getsimpleclassname)
- `->`[`nextToken()`](#method-nexttoken)
- `->`[`getUsages()`](#method-getusages)
- `->`[`getUsagesAliases()`](#method-getusagesaliases)
- `->`[`getName()`](#method-getname)
- `->`[`getReflection()`](#method-getreflection)

---
# Methods

<a name="method-__construct"></a>

### __construct()
```php
__construct(string $source): void
```
UsagesParser constructor.

---

<a name="method-parse"></a>

### parse()
```php
parse(): void
```

---

<a name="method-tokenizesource"></a>

### tokenizeSource()
```php
tokenizeSource(): void
```

---

<a name="method-store"></a>

### store()
```php
store(string $usage): void
```

---

<a name="method-storealias"></a>

### storeAlias()
```php
storeAlias(string $alias, mixed $class): void
```

---

<a name="method-getsimpleclassname"></a>

### getSimpleClassName()
```php
getSimpleClassName(string $class): string
```

---

<a name="method-nexttoken"></a>

### nextToken()
```php
nextToken(): phpx\parser\SourceToken
```

---

<a name="method-getusages"></a>

### getUsages()
```php
getUsages(): array
```

---

<a name="method-getusagesaliases"></a>

### getUsagesAliases()
```php
getUsagesAliases(): array
```

---

<a name="method-getname"></a>

### getName()
```php
getName(string $alias): string
```

---

<a name="method-getreflection"></a>

### getReflection()
```php
getReflection(string $alias): ReflectionClass
```