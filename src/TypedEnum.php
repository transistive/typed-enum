<?php /** @noinspection LateStaticBindingInspection */

declare(strict_types=1);

namespace Youngsource\TypedEnum;

use ReflectionClass;
use Youngsource\TypedEnum\Errors\InvalidEnumerationError;
use Youngsource\TypedEnum\Errors\NonExistingEnumerationError;
use function is_scalar;
use function sprintf;

/**
 * A simple typed enumeration.
 *
 * Class whose constants define an enumeration
 *
 * @template T of scalar
 */
abstract class TypedEnum
{
    private static ?TypedEnumCollectionManager $manager = null;
    /** @var T */
    private $value;

    /**
     * @param T $value
     */
    final private function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @param null $args
     * @throws NonExistingEnumerationError|InvalidEnumerationError
     */
    final public static function __callStatic(string $name, $args): TypedEnum
    {
        $manager = static::bootIfNotBooted();
        $value = $manager->get(static::class)->get($name);
        if ($value === null) {
            throw new NonExistingEnumerationError(sprintf('No enumeration found for: %s::%s', static::class, $name));
        }
        return $value;
    }

    /**
     * @throws InvalidEnumerationError
     */
    private static function bootIfNotBooted(): TypedEnumCollectionManager
    {
        if (self::$manager === null) {
            self::$manager = new TypedEnumCollectionManager();
        }

        if (!self::$manager->exists(static::class)) {
            static::boot(self::$manager);
        }

        return self::$manager;
    }

    /**
     * @throws InvalidEnumerationError
     */
    private static function boot(TypedEnumCollectionManager $manager): void
    {
        $reflection = new ReflectionClass(static::class);

        $tbr = [];
        foreach ($reflection->getReflectionConstants() as $constant) {
            $value = $constant->getValue();
            if (!is_scalar($value)) {
                throw new InvalidEnumerationError(
                    sprintf('The enumeration %s::%s is not a scalar value', static::class, $constant->getName())
                );
            }
            $tbr[$constant->getName()] = new static($value);
        }
        $manager->add(static::class, new TypedEnumCollection($tbr));
    }

    /**
     * Resolves the enumeration based on its value
     *
     * @template U of scalar
     * @param U $constValue
     * @return static<U>|null
     *
     * @throws InvalidEnumerationError
     */
    final public static function resolve($constValue): ?TypedEnum
    {
        $manager = static::bootIfNotBooted();
        return $manager->get(static::class)->search($constValue);
    }

    /**
     * @return array<string, TypedEnum>
     *
     * @throws InvalidEnumerationError
     */
    final public static function getAllInstances(): array
    {
        $manager = static::bootIfNotBooted();
        return $manager->get(static::class)->toArray();
    }

    /**
     * @return T
     */
    final public function getValue()
    {
        return $this->value;
    }
}

