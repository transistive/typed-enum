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
     * @template T of TypedEnum
     *
     * @param class-string<T> $class
     *
     * @return Map<string, T>
     */
    public function get(string $class): Map
    {
        /** @var Map<string, T>|null $tbr */
        $tbr = $this->mappings->get($class, null);

        if ($tbr === null) {
            $reflector = new ReflectionClass($class);

            /** @var Map<string, T> $tbr */
            $tbr = new Map();
            foreach ($reflector->getReflectionConstants() as $constant) {
                $tbr->put($constant->getName(), new $class($constant->getValue()));
            }

            $this->mappings->put($reflector->getName(), $tbr);
        }

        return $tbr;
    }
}
