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

/**
 * @internal
 * @template T of array<string, TypedEnum>
 */
final class TypedEnumCollection
{
    /** @var T */
    private array $enumValues;

    /**
     * @param T $enumValues
     */
    public function __construct(array $enumValues)
    {
        $this->enumValues = $enumValues;
    }

    public function get(string $key): ?TypedEnum
    {
        return $this->enumValues[$key] ?? null;
    }

    /**
     * @return T
     */
    public function toArray(): array
    {
        return $this->enumValues;
    }

    /**
     * @template U
     *
     * @param U $value
     *
     * @return array<int, TypedEnum<U>>
     */
    public function search($value): array
    {
        return array_values(array_filter($this->enumValues, static fn ($enum) => $enum->getValue() === $value));
    }
}
