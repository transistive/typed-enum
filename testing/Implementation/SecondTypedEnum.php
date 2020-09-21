<?php


namespace Youngsource\TypedEnum\Tests\Implementation;

use Youngsource\TypedEnum\TypedEnum;

/**
 * @method static<string> TypedEnumFilled TEST()
 * @method static<string> TypedEnumFilled TEST_NO_SAME_VALUE()
 * @method static<int> TypedEnumFilled TEST_NUMERIC()
 * @method static<null> TypedEnumFilled TEST_NULL()
 * @method static<string> TypedEnumFilled TEST_SAME_ONE()
 * @method static<string> TypedEnumFilled TEST_SAME_TWO()
 */
final class SecondTypedEnum extends TypedEnum
{
    private const TEST = 'test';
    private const TEST_NO_SAME_VALUE = 'abc';
    private const TEST_NUMERIC = 1;
    private const TEST_SAME_ONE = 'same';
    private const TEST_SAME_TWO = 'same';
}