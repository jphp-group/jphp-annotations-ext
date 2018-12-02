# ArgumentParser

- **class** `ArgumentParser` (`annotations\ArgumentParser`)
- **source** `annotations/ArgumentParser.php`

---

#### Properties

- `->`[`pos`](#prop-pos) : `int`
- `->`[`len`](#prop-len) : `int`
- `->`[`input`](#prop-input) : `string`
- `->`[`positionArgs`](#prop-positionargs) : `mixed`
- `->`[`namedArgs`](#prop-namedargs) : `mixed`

---

#### Methods

- `->`[`__construct()`](#method-__construct) - _ArgumentParser constructor._
- `->`[`getPositionArgs()`](#method-getpositionargs)
- `->`[`getNamedArgs()`](#method-getnamedargs)
- `->`[`parse()`](#method-parse)
- `->`[`readValue()`](#method-readvalue)
- `->`[`readNumber()`](#method-readnumber)
- `->`[`readString()`](#method-readstring)
- `->`[`readArray()`](#method-readarray)
- `->`[`readName()`](#method-readname)
- `->`[`skipWhitespaces()`](#method-skipwhitespaces)
- `->`[`skip()`](#method-skip)
- `->`[`is()`](#method-is)
- `->`[`isLetter()`](#method-isletter)
- `->`[`isDigit()`](#method-isdigit)
- `->`[`inRange()`](#method-inrange)
- `->`[`peek()`](#method-peek)
- `->`[`current()`](#method-current)
- `->`[`jump()`](#method-jump)
- `->`[`next()`](#method-next)
- `->`[`pre()`](#method-pre)

---
# Methods

<a name="method-__construct"></a>

### __construct()
```php
__construct(string $input): void
```
ArgumentParser constructor.

---

<a name="method-getpositionargs"></a>

### getPositionArgs()
```php
getPositionArgs(): array
```

---

<a name="method-getnamedargs"></a>

### getNamedArgs()
```php
getNamedArgs(): array
```

---

<a name="method-parse"></a>

### parse()
```php
parse(): void
```

---

<a name="method-readvalue"></a>

### readValue()
```php
readValue(): void
```

---

<a name="method-readnumber"></a>

### readNumber()
```php
readNumber(): void
```

---

<a name="method-readstring"></a>

### readString()
```php
readString(): string
```

---

<a name="method-readarray"></a>

### readArray()
```php
readArray(): void
```

---

<a name="method-readname"></a>

### readName()
```php
readName(boolean $detectKeywords): void
```

---

<a name="method-skipwhitespaces"></a>

### skipWhitespaces()
```php
skipWhitespaces(): void
```

---

<a name="method-skip"></a>

### skip()
```php
skip(string $c): void
```

---

<a name="method-is"></a>

### is()
```php
is(string $c, int $amount, boolean $skipWhiteSpaces): boolean
```

---

<a name="method-isletter"></a>

### isLetter()
```php
isLetter(int $amount): void
```

---

<a name="method-isdigit"></a>

### isDigit()
```php
isDigit(int $amount): void
```

---

<a name="method-inrange"></a>

### inRange()
```php
inRange(string $a, string $b, int $amount): void
```

---

<a name="method-peek"></a>

### peek()
```php
peek(int $amount): string
```

---

<a name="method-current"></a>

### current()
```php
current(): string
```

---

<a name="method-jump"></a>

### jump()
```php
jump(int $amount, boolean $collect): string
```

---

<a name="method-next"></a>

### next()
```php
next(): string
```

---

<a name="method-pre"></a>

### pre()
```php
pre(): string
```