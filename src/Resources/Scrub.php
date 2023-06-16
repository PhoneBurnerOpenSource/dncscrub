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

namespace PhoneBurner\DNCScrub\Resources;

use PhoneBurner\DNCScrub\Exceptions\BadRequest;
use PhoneBurner\DNCScrub\Result;

class Scrub extends Resource
{
    use WithPhones;

    private const ENDPOINT = '/app/main/rpc/scrub';

    /**
     * @return array<string|int,Result>
     */
    private function parseBody(string $body): array
    {
        $results = [];
        $rows = \explode("\n", $body);
        foreach ($rows as $row) {
            if (! $row) {
                continue;
            }

            $result = Result::fromCSV($row);

            $results[$result->getPhone()] = $result;
        }

        return $results;
    }

    /**
     * @return array<string|int,Result>
     */
    public function request(): array
    {
        [$response_code, $body] = $this->client->request('post', self::ENDPOINT, $this->options);

        if ($response_code === 200 && \strpos($body, '<title>Login</title>')) {
            throw new BadRequest('Bad request', 401);
        }

        if ($response_code === 200) {
            return $this->parseBody($body);
        }

        throw new BadRequest('Bad request', $response_code);
    }
}
