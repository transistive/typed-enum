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

namespace Laudis\TypedEnum\Tests\Unit;

use Laudis\TypedEnum\Errors\NonExistingEnumerationError;
use Laudis\TypedEnum\Tests\Implementation\NonScalarImplementation;
use Laudis\TypedEnum\Tests\Implementation\SecondTypedEnum;
use Laudis\TypedEnum\Tests\Implementation\TypedEnumFilled;
use Laudis\TypedEnum\TypedEnumCollection;
use Laudis\TypedEnum\TypedEnumCollectionManager;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class TypedEnumCollectionManagerTest extends TestCase
{
    private TypedEnumCollectionManager $manager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->manager = new TypedEnumCollectionManager();
    }

    public function testReflectionEmpty(): void
    {
        $values = $this->manager->get(NonExistingEnumerationError::class);
        static::assertEquals(new TypedEnumCollection([]), $values);
    }

    public function testEquals(): void
    {
        $values = $this->manager->get(NonScalarImplementation::class);
        static::assertEquals(NonScalarImplementation::NULL(), $values->get('NULL'));
    }

    public function testMultiple(): void
    {
        $values = $this->manager->get(SecondTypedEnum::class);
        static::assertEquals(SecondTypedEnum::TEST(), $values->get('TEST'));
        static::assertEquals(SecondTypedEnum::TEST_NO_SAME_VALUE(), $values->get('TEST_NO_SAME_VALUE'));
        static::assertEquals(SecondTypedEnum::TEST_NUMERIC(), $values->get('TEST_NUMERIC'));
        static::assertEquals(SecondTypedEnum::TEST_SAME_ONE(), $values->get('TEST_SAME_ONE'));
        static::assertEquals(SecondTypedEnum::TEST_SAME_TWO(), $values->get('TEST_SAME_TWO'));
    }

    public function testSame(): void
    {
        $values = $this->manager->get(NonScalarImplementation::class);
        static::assertNotNull($values->get('NULL'));
        static::assertSame($this->manager->get(NonScalarImplementation::class)->get('NULL'), $values->get('NULL'));
    }

    public function testEqualsButNotSame(): void
    {
        $values = $this->manager->get(TypedEnumFilled::class);
        $otherValues = (new TypedEnumCollectionManager())->get(TypedEnumFilled::class);
        static::assertEquals($values, $otherValues);
        static::assertNotSame($values, $otherValues);
    }
}
