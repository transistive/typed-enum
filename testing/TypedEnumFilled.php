<?php

namespace Youngsource\TypedEnum\Tests;

use Youngsource\TypedEnum\TypedEnum;

/**
 * Class TypedEnumFilled
 *
 *
 * @method static TypedEnumFilled TEST()
 * @method static TypedEnumFilled TEST_NO_SAME_VALUE()
 * @method static TypedEnumFilled TEST_NUMERIC()
 * @method static TypedEnumFilled TEST_NULL()
 * @method static TypedEnumFilled TEST_SAME_ONE()
 * @method static TypedEnumFilled TEST_SAME_TWO()
 *
 * @package Youngsource\TypedEnum\Tests
 */
final class TypedEnumFilled extends TypedEnum
{
    protected const TEST = 'test';
    protected const TEST_NO_SAME_VALUE = 'abc';
    protected const TEST_NUMERIC = 1;
    protected const TEST_NULL = null;
    protected const TEST_SAME_ONE = 'same';
    protected const TEST_SAME_TWO = 'same';
}
