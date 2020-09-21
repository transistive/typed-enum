<?php


namespace Youngsource\TypedEnum;

/**
 * @internal
 * @template T of array<string, TypedEnum>
 */
final class TypedEnumCollection
{
    /** @var T  */
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
     * @template U of scalar
     * @param U $value
     * @return TypedEnum<U>|null
     */
    public function search($value): ?TypedEnum
    {
        foreach ($this->enumValues as $enumValue) {
            if ($enumValue->getValue() === $value) {
                return $enumValue;
            }
        }
        return null;
    }
}