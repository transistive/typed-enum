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

use ReflectionClass;

/**
 * @internal
 */
final class TypedEnumCollectionManager
{
    /** @var array<class-string<TypedEnum>, TypedEnumCollection> */
    private array $mappings = [];

    /**
     * @template T
     *
     * @param class-string<TypedEnum> $class
     */
    public function get(string $class): TypedEnumCollection
    {
        if (!isset($this->mappings[$class])) {
            $reflector = new ReflectionClass($class);

            $tbr = [];
            foreach ($reflector->getReflectionConstants() as $constant) {
                $tbr[$constant->getName()] = new $class($constant->getValue());
            }

            $this->mappings[$reflector->getName()] = new TypedEnumCollection($tbr);
        }

        return $this->mappings[$class];
    }
}
