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

use Laudis\TypedEnum\Errors\InvalidEnumerationError;
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
     * @internal
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @param null $args
     *
     * @throws InvalidEnumerationError|NonExistingEnumerationError
     */
    final public static function __callStatic(string $name, $args): self
    {
        $value = static::bootIfNotBooted()->get(static::class)->get($name);
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
     * @throws InvalidEnumerationError
     *
     * @return array<int, static<U>>
     */
    final public static function resolve($constValue): ?array
    {
        return static::bootIfNotBooted()->get(static::class)->search($constValue);
    }

    /**
     * @throws InvalidEnumerationError
     *
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

    /**
     * @throws InvalidEnumerationError
     */
    private static function bootIfNotBooted(): TypedEnumCollectionManager
    {
        if (self::$manager === null) {
            self::$manager = new TypedEnumCollectionManager();
        }

        return self::$manager;
    }
}
