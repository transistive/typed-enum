<?php

declare(strict_types=1);

/*
 * This file is part of the Laudis TypedEnum library
 *
 * (c) Laudis <https://laudis.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Laudis\TypedEnum;

use Ds\Sequence;
use Laudis\TypedEnum\Errors\NonExistingEnumerationError;
use function sprintf;

/**
 * A simple typed enumeration.
 *
 * Class whose constants define an enumeration
 *
 * @template T
 */
abstract class TypedEnum
{
    private static ?TypedEnumCollectionManager $manager = null;
    /** @var T */
    private $value;

    /**
     * @param T $value
     *
     * @internal
     */
    final public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @param null $args
     *
     * @throws NonExistingEnumerationError
     */
    final public static function __callStatic(string $name, $args): self
    {
        $value = static::bootIfNotBooted()->get(static::class)->get($name, null);
        if ($value === null) {
            throw new NonExistingEnumerationError(sprintf('No enumeration found for: %s::%s', static::class, $name));
        }

        return $value;
    }

    /**
     * Resolves the enumeration based on its value.
     *
     * @template U of scalar
     *
     * @param U $constValue
     *
     * @return Sequence<TypedEnum<U>>
     */
    final public static function resolve($constValue): Sequence
    {
        $predicate = static function (string $key, TypedEnum $enum) use ($constValue): bool {
            return $enum->getValue() === $constValue;
        };

        return static::bootIfNotBooted()->get(static::class)->filter($predicate)->values();
    }

    /**
     * @return array<string, TypedEnum>
     */
    final public static function getAllInstances(): array
    {
        return static::bootIfNotBooted()->get(static::class)->toArray();
    }

    /**
     * @return T
     */
    final public function getValue()
    {
        return $this->value;
    }

    private static function bootIfNotBooted(): TypedEnumCollectionManager
    {
        if (self::$manager === null) {
            self::$manager = new TypedEnumCollectionManager();
        }

        return self::$manager;
    }
}
