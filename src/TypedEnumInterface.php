<?php

namespace Youngsource\TypedEnum;

use LogicException;

/**
 * Interface TypedEnumInterface
 * Interface outlining the behaviour of a Typed Enumeration.
 */
interface TypedEnumInterface
{
	/**
	 * Returns all the instances of the enumeration.
     *
	 * @return array|TypedEnumInterface[]
	 */
	public static function getAllInstances(): array;

	/**
	 * Resolves the Typed Enum instance from the value first found assigned to it.
	 *
	 * @param mixed $value Resolves the enumeration instance
	 * @return null|TypedEnumInterface
	 */
	public static function resolve($value): ?TypedEnumInterface;

	/**
	 * Call an enumeration statically.
	 *
	 * @param string $name The name of the enumeration.
	 * @param string ...$variables The variables passed to the enumeration.
	 * @return mixed
     * @throws LogicException thrown if the enumeration does not exist
	 */
	public static function __callStatic($name, $variables);

	/**
	 * Returns the value of the enumerated instance.
	 *
	 * @return mixed
	 */
	public function getValue();
}
