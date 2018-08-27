# Typed Enumerations

A simple, lightweight, efficient and extensible typed enumeration library. Type hint your enumerated options in an efficient and strict way to eliminate unintended side effects and bugs introduced by typo's.

## How to use:

### Download

Download with composer:
```
composer require "youngsource/typed-enum"
```

### Extending from TypedEnum 

Extend from TypedEnum and use protected or public constants to define the enumeration:

```
final Foo extends TypedEnum {
    protected const BAR = 'bar';
    protected const BAZ = 'bas';
} 
```

Instances of Foo can now be created by using the __callstatic method based on the name of the constant:

```
Foo::BAR()  // Returns an instance of Foo with value 'bar'
```

### Testing for equality

Testing for equality can be done in a strict way as TypedEnum guarantees there to be only one instance of the same enumerated value at runtime.

```
function isBar(Foo $enum): bool {
    return Foo::BAR() === $enum;     
}
```

### Return the actual value:

If your application depends on the value assigned tot he enumeration, you can easily fetch it with the getValue() getter.

```
echo Foo::BAR()->getValue(); //'bar'
```

### Resolve the enumeration

Resolve an enumeration based on it's value. 
> NOTE: The resolving is based on the first found value that was assigned to it:

```
echo Foo::resolve('bar') === Foo::BAR() // true 
```

## Custom solutions

### The TypedEnumInterface

Simply use the interface if you do not want to extend the TypedEnum class and design your own implementation.

```
final class Bar implements TypedEnumInterface {
    
    /**
	 * Returns all the instances of the enumeration.
     *
	 * @return array|TypedEnumInterface[]
	 */
	public static function getAllInstances(): array 
	{
	    // custom logic here
	}

	/**
	 * Resolves the Typed Enum instance from the value first found assigned to it.
	 *
	 * @param mixed $value Resolves the enumeration instance
	 * @return null|TypedEnumInterface
	 */
	public static function resolve($value): ?TypedEnumInterface 
	{
	    // custom logic here
	}

	/**
	 * Call an enumeration statically.
	 *
	 * @param string $name The name of the enumeration.
	 * @param string ...$variables The variables passed to the enumeration.
	 * @return mixed
     * @throws LogicException thrown if the enumeration does not exist
	 */
	public static function __callStatic($name, $variables)
	{
	    // custom logic here
	}

	/**
	 * Returns the value of the enumerated instance.
	 *
	 * @return mixed
	 */
	public function getValue()
	{
	    // custom logic here
	}
}
```

### The boot method

The boot fase is defined as the moment exactly before the first enumerated value enters the application. A simple hook into this bootfase of the TypedEnum can be achieved by overriding the boot() method:

```
final class Baz extends TypedEnum {
    protected static function boot(): void {
        parent::boot();
        echo 'booting';
    }
    protected const BOOT = 'boot';
    protected const AFTER_BOOT = 'after boot';
}

\\\Somewhere in your application
Baz::BOOT(); // echo's boot and returns the TypedEnum
Baz::BOOT(); // Just returns the TypedEnum
Baz::AFTER_BOOT(); // Just returns the TypedEnum
```

### Hook into the initialization fase

The initialization fase is defined as the moment a specific enumerated value enters the application: A simple hook into the initialization fase can be achieved by extending the initialization method.

```
final class Baz extends TypedEnum {
    protected function initialize($value): void {
        parent::initialize($value);
        echo "initializing $value";
    }
    protected const INIT_ONE = 'one';
    protected const INIT_TWO = 'two';
}

\\\Somewhere in your application
Baz::INIT_ONE(); // echo's 'initalizing one' and returns the TypedEnum
Baz::INIT_ONE(); // Just returns the TypedEnum
Baz::INIT_TWO(); // echo's 'initialzing two' and returns the TypedEnum
```

## Tips

### IDE integration

You can easily use the power of you ide by simply adding @method tags in the docblock of your class like this:

```
/**
 * @method static TypedEnum TEST()
 */
final Foo extends TypedEnum {
    protected const TEST = 'test';
}
```

### Easy Bug protection

Php 7.2 allows for protected constants, use them for unintended side effects:

```
echo Foo::BAR === Foo::BAR() // echo's false but is impossible if it was a protected constant
```


***
Developed by [youngsource](https://www.youngsource.be)
