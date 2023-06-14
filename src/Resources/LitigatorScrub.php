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

class LitigatorScrub extends Resource
{
    use WithPhones;

    private string $endpoint = '/apiLatest/scrub/litigator';

    /**
     * @var array<string|int, bool>
     */
    private array $results = [];

    /**
     * @return array<string|int, bool>
     */
    public function request(): array
    {
        $endpoint = \vsprintf("%s?phoneList=%s&version=%s", [
            $this->endpoint,
            (string)$this->options['form_params']['phoneList'],
            (string)$this->options['form_params']['version'],
        ]);

        [$response_code, $body] = $this->client->request('get', $endpoint);

        if ($response_code === 200 && \strpos($body, '<title>Login</title>')) {
            throw new BadRequest('Bad request', 401);
        }

        if ($response_code === 200) {
            $this->parseBody($body);
            return $this->results;
        }

        throw new BadRequest('Bad request', $response_code);
    }

    private function parseBody(string $body): void
    {
        $rows = (array)\json_decode($body, true, 512, \JSON_THROW_ON_ERROR);
        foreach ($rows as $row) {
            \assert(\is_array($row));
            $this->results[$row['Phone']] = (bool)$row['IsLitigator'];
        }
    }
}
