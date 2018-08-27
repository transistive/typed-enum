<?php

namespace Youngsource\TypedEnum\Testing;

use PHPUnit\Framework\TestCase;
use Youngsource\TypedEnum\Tests\TypedEnumFilled;

/**
 * Class TypedEnumTest
 * @package Youngsource\TypedEnum\Testing
 */
class TypedEnumTest extends TestCase
{
    public function testCallInt(): void
    {
        static::assertEquals(1, TypedEnumFilled::TEST_NUMERIC()->getValue());
    }

    public function testDifferentInt(): void
    {
        static::assertEquals('abc', TypedEnumFilled::TEST_NO_SAME_VALUE()->getValue());
    }

    public function testCallNull(): void
    {
        static::assertNull(TypedEnumFilled::TEST_NULL()->getValue());
    }

    public function testCallString(): void
    {
        static::assertEquals('test', TypedEnumFilled::TEST()->getValue());
    }

    public function testCallSame(): void
    {
        static::assertEquals('same', TypedEnumFilled::TEST_SAME_ONE()->getValue());
        static::assertEquals('same', TypedEnumFilled::TEST_SAME_TWO()->getValue());
    }

    public function testResolveInt(): void
    {
        static::assertEquals(TypedEnumFilled::TEST_NUMERIC(), TypedEnumFilled::resolve(1));
    }

    public function testResolveDifferent(): void
    {
        static::assertEquals(TypedEnumFilled::TEST_NO_SAME_VALUE(), TypedEnumFilled::resolve('abc'));
    }

    public function testResolveNull(): void
    {
        static::assertEquals(TypedEnumFilled::TEST_NULL(), TypedEnumFilled::resolve(null));
    }

    public function testResolveString(): void
    {
        static::assertEquals(TypedEnumFilled::TEST(), TypedEnumFilled::resolve('test'));
    }

    public function testResolveSame(): void
    {
        static::assertEquals(TypedEnumFilled::TEST_SAME_ONE(), TypedEnumFilled::resolve('same'));
        static::assertEquals(TypedEnumFilled::TEST_SAME_TWO(), TypedEnumFilled::resolve('same'));
    }

    public function testGetAllInstances(): void
    {
        static::assertEquals(
            [
                'TEST' => TypedEnumFilled::TEST(),
                'TEST_NO_SAME_VALUE' => TypedEnumFilled::TEST_NO_SAME_VALUE(),
                'TEST_NUMERIC' => TypedEnumFilled::TEST_NUMERIC(),
                'TEST_NULL' => TypedEnumFilled::TEST_NULL(),
                'TEST_SAME_ONE' => TypedEnumFilled::TEST_SAME_ONE(),
                'TEST_SAME_TWO' => TypedEnumFilled::TEST_SAME_TWO(),
            ],
            TypedEnumFilled::getAllInstances()
        );
    }
}
