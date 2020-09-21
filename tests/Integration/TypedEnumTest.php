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

namespace Laudis\TypedEnum\Tests\Integration;

use Laudis\TypedEnum\Errors\NonExistingEnumerationError;
use Laudis\TypedEnum\Tests\Implementation\SecondTypedEnum;
use Laudis\TypedEnum\Tests\Implementation\TypedEnumFilled;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class TypedEnumTest extends TestCase
{
    public function testCallInt(): void
    {
        static::assertSame(1, TypedEnumFilled::TEST_NUMERIC()->getValue());
    }

    public function testDifferentInt(): void
    {
        static::assertSame('abc', TypedEnumFilled::TEST_NO_SAME_VALUE()->getValue());
    }

    public function testCallString(): void
    {
        static::assertSame('test', TypedEnumFilled::TEST()->getValue());
    }

    public function testCallSame(): void
    {
        static::assertSame('same', TypedEnumFilled::TEST_SAME_ONE()->getValue());
        static::assertSame('same', TypedEnumFilled::TEST_SAME_TWO()->getValue());
    }

    public function testResolveInt(): void
    {
        static::assertSame([TypedEnumFilled::TEST_NUMERIC()], TypedEnumFilled::resolve(1));
    }

    public function testResolveDifferent(): void
    {
        static::assertSame([TypedEnumFilled::TEST_NO_SAME_VALUE()], TypedEnumFilled::resolve('abc'));
    }

    public function testResolveString(): void
    {
        static::assertSame([TypedEnumFilled::TEST()], TypedEnumFilled::resolve('test'));
    }

    public function testResolveSame(): void
    {
        static::assertSame([TypedEnumFilled::TEST_SAME_ONE(), TypedEnumFilled::TEST_SAME_TWO()], TypedEnumFilled::resolve('same'));
    }

    public function testGetAllInstances(): void
    {
        static::assertSame(
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
        static::assertSame(
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
        static::assertNotSame(SecondTypedEnum::TEST(), TypedEnumFilled::TEST());
        static::assertNotSame(SecondTypedEnum::TEST_NO_SAME_VALUE(), TypedEnumFilled::TEST_NO_SAME_VALUE());
        static::assertNotSame(SecondTypedEnum::TEST_NUMERIC(), TypedEnumFilled::TEST_NUMERIC());
        static::assertNotSame(SecondTypedEnum::TEST_SAME_ONE(), TypedEnumFilled::TEST_SAME_ONE());
        static::assertNotSame(SecondTypedEnum::TEST_SAME_TWO(), TypedEnumFilled::TEST_SAME_TWO());
    }

    public function testNonEnumeration(): void
    {
        $this->expectException(NonExistingEnumerationError::class);
        SecondTypedEnum::ABC();
    }

    public function testResolveNull(): void
    {
        static::assertEmpty(SecondTypedEnum::resolve('fdjker;qahg'));
    }
}
