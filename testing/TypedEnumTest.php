<?php

namespace Youngsource\TypedEnum\Testing;

use PHPUnit\Framework\TestCase;
use Youngsource\TypedEnum\Errors\InvalidEnumerationError;
use Youngsource\TypedEnum\Errors\NonExistingEnumerationError;
use Youngsource\TypedEnum\Tests\Implementation\NonScalarImplementation;
use Youngsource\TypedEnum\Tests\Implementation\SecondTypedEnum;
use Youngsource\TypedEnum\Tests\Implementation\TypedEnumFilled;

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

    public function testResolveString(): void
    {
        static::assertEquals(TypedEnumFilled::TEST(), TypedEnumFilled::resolve('test'));
    }

    public function testResolveSame(): void
    {
        static::assertEquals(TypedEnumFilled::TEST_SAME_ONE(), TypedEnumFilled::resolve('same'));
        static::assertNotSame(TypedEnumFilled::TEST_SAME_TWO(), TypedEnumFilled::resolve('same'));
    }

    public function testGetAllInstances(): void
    {
        static::assertEquals(
            [
                'TEST' => TypedEnumFilled::TEST(),
                'TEST_NO_SAME_VALUE' => TypedEnumFilled::TEST_NO_SAME_VALUE(),
                'TEST_NUMERIC' => TypedEnumFilled::TEST_NUMERIC(),
                'TEST_SAME_ONE' => TypedEnumFilled::TEST_SAME_ONE(),
                'TEST_SAME_TWO' => TypedEnumFilled::TEST_SAME_TWO(),
            ],
            TypedEnumFilled::getAllInstances()
        );
    }

    public function testGetAllInstancesReversed(): void
    {
        static::assertEquals(
            TypedEnumFilled::getAllInstances(),
            [
                'TEST' => TypedEnumFilled::TEST(),
                'TEST_NO_SAME_VALUE' => TypedEnumFilled::TEST_NO_SAME_VALUE(),
                'TEST_NUMERIC' => TypedEnumFilled::TEST_NUMERIC(),
                'TEST_SAME_ONE' => TypedEnumFilled::TEST_SAME_ONE(),
                'TEST_SAME_TWO' => TypedEnumFilled::TEST_SAME_TWO(),
            ]
        );
    }

    public function testEqual(): void
    {
        static::assertSame(TypedEnumFilled::TEST(), TypedEnumFilled::TEST());
    }

    public function testAssertNotSameInExtendedVersion(): void
    {
        self::assertNotSame(SecondTypedEnum::TEST(), TypedEnumFilled::TEST());
        self::assertNotSame(SecondTypedEnum::TEST_NO_SAME_VALUE(), TypedEnumFilled::TEST_NO_SAME_VALUE());
        self::assertNotSame(SecondTypedEnum::TEST_NUMERIC(), TypedEnumFilled::TEST_NUMERIC());
        self::assertNotSame(SecondTypedEnum::TEST_SAME_ONE(), TypedEnumFilled::TEST_SAME_ONE());
        self::assertNotSame(SecondTypedEnum::TEST_SAME_TWO(), TypedEnumFilled::TEST_SAME_TWO());
    }

    public function testWrongImplementation(): void
    {
        try {
            NonScalarImplementation::NULL();
        } catch (InvalidEnumerationError $e) {
            self::assertTrue(true);
        }
    }

    public function testNonEnumeration(): void
    {
        try {
            SecondTypedEnum::ABC();
        } catch (NonExistingEnumerationError $e) {
            self::assertTrue(true);
        }
    }
}
