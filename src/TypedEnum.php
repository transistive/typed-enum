<?php

declare(strict_types=1);

namespace Youngsource\TypedEnum;

use LogicException;
use ReflectionClass;
use function is_array;

/**
 * A simple typed enumeration.
 *
 * Class whose constants define an enumeration
 */
abstract class TypedEnum implements TypedEnumInterface
{
    /** @var array[] keeps track of all the reflected constants */
    private static $enums = [];
    /** @var mixed */
    private $value;

    /**
     * TypedEnum constructor.
     *
     * @param mixed $value
     */
    private function __construct($value)
    {
        $this->initialize($value);
    }

    /**
     * Initializes the enumerated value.
     *
     * @param mixed $value
     */
    protected function initialize($value): void
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    final public static function __callStatic($name, $variables)
    {
        static::bootIfNotBooted();
        if (!static::constantExists($name)) {
            throw new LogicException("Method with given name: $name does not exists");
        }
        $enum = static::getEnums()[$name];
        return  static::getEnums()[$name] = $enum instanceof TypedEnumInterface ?
            $enum :
            new static($enum);
    }

    /**
     * Boots the Typed Enum if it didn't happen already.
     */
    protected static function bootIfNotBooted(): void
    {
        if (!static::isBooted()) {
            static::boot();
        }
    }

    /**
     * Checks to see if the Typed Enum has been booted already.
     * @return bool
     */
    private static function isBooted(): bool
    {
        return is_array(self::$enums[static::class] ?? false);
    }

    /**
     * Boots the TypedEnum class.
     */
    protected static function boot(): void
    {
        /** @noinspection PhpUnhandledExceptionInspection  cannot be thrown as the static::class always exists. */
        $reflection = new ReflectionClass(static::class);
        self::$enums[static::class] = $reflection->getConstants();
    }

    /**
     * Checks to see if the constant exists.
     *
     * @param string $constant
     * @return bool
     */
    private static function constantExists(string $constant): bool
    {
        return array_key_exists($constant, static::getEnums());
    }

    /**
     * @return array
     */
    private static function & getEnums(): array
    {
        return self::$enums[static::class];
    }

    /**
     * {@inheritdoc}
     */
    public static function resolve($constValue): ?TypedEnumInterface
    {
        static::bootIfNotBooted();
        foreach (static::getEnums() as $constant => $value) {
            if ($value instanceof TypedEnumInterface && $value->getValue() === $constValue) {
                return $value;
            }
            if ($value === $constValue) {
                static::getEnums()[$constant] = new static($value);
                return static::getEnums()[$constant];
            }
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public static function getAllInstances(): array
    {
        static::bootIfNotBooted();
        return self::$enums[static::class] = array_map(
            function ($value) {
                return $value instanceof TypedEnumInterface ? $value : new static($value);
            },
            static::getEnums()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->value;
    }
}

