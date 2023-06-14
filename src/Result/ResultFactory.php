<?php

/**
 * Copyright 2023 PhoneBurner
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

declare(strict_types=1);

namespace PhoneBurner\DNCScrub\Result;

use RuntimeException;

class ResultFactory
{
    private const MAP = [
        'B' => B::class,
        'C' => C::class,
        'D' => D::class,
        'E' => E::class,
        'F' => F::class,
        'G' => G::class,
        'H' => H::class,
        'I' => B::class,
        'L' => I::class,
        'M' => M::class,
        'O' => O::class,
        'P' => P::class,
        'R' => R::class,
        'V' => V::class,
        'W' => W::class,
        'X' => X::class,
        'Y' => Y::class,
    ];

    public function make(string $status): ResultCode
    {
        $class = self::MAP[$status] ?? null;
        if ($class !== null) {
            return new $class();
        }

        throw new RuntimeException('Invalid Result: ' . $status);
    }

    /**
     * @return array<string, ResultCode>
     */
    public function getPossibleResults(): array
    {
        return \array_map(static fn(string $class): ResultCode => new $class(), self::MAP);
    }
}
