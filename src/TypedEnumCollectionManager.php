<?php


namespace Youngsource\TypedEnum;

/**
 * @internal
 */
final class TypedEnumCollectionManager
{
    /** @var array<class-string<TypedEnum>, TypedEnumCollection> */
    private array $mappings = [];

    /**
     * @param class-string<TypedEnum> $class
     */
    public function add(string $class, TypedEnumCollection $collection): void
    {
        $this->mappings[$class] = $collection;
    }

    public function exists(string $class): bool
    {
        return isset($this->mappings[$class]);
    }

    /**
     * @param class-string<TypedEnum> $class
     */
    public function get(string $class): TypedEnumCollection
    {
        return $this->mappings[$class];
    }
}