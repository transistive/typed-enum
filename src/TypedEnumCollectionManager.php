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

use Ds\Map;
use ReflectionClass;

/**
 * @internal
 */
final class TypedEnumCollectionManager
{
    /** @var Map<class-string<TypedEnum>, Map<string, TypedEnum>> */
    private Map $mappings;

    public function __construct()
    {
        $this->mappings = new Map();
    }

    /**
     * @template T
     *
     * @param class-string<TypedEnum> $class
     *
     * @return Map<string, TypedEnum>
     */
    public function get(string $class): Map
    {
        if (!isset($this->mappings[$class])) {
            $reflector = new ReflectionClass($class);

            /** @var Map<string, TypedEnum> $tbr */
            $tbr = new Map();
            foreach ($reflector->getReflectionConstants() as $constant) {
                $tbr[$constant->getName()] = new $class($constant->getValue());
            }

            $this->mappings[$reflector->getName()] = $tbr;

            return $tbr;
        }

        return $this->mappings[$class];
    }
}
