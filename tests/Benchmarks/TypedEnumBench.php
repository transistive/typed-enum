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

namespace Laudis\TypedEnum\Tests\Benchmarks;

use Laudis\TypedEnum\Tests\Implementation\TypedEnumFilled;

final class TypedEnumBench
{
    /**
     * @Revs({1, 8, 4096, 8192})
     * @Iterations(5)
     */
    public function benchSetup(): void
    {
        TypedEnumFilled::getAllInstances();
    }

    /**
     * @Revs({1, 8, 4096, 8192})
     * @Iterations(5)
     */
    public function benchAccess(): void
    {
        TypedEnumFilled::TEST();
        TypedEnumFilled::TEST_NO_SAME_VALUE();
        TypedEnumFilled::TEST_NUMERIC();
        TypedEnumFilled::TEST_SAME_ONE();
        TypedEnumFilled::TEST_SAME_TWO();
    }
}
