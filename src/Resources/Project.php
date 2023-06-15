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

class Project extends Resource
{
    private const ENDPOINT = '/app/main/rpc/project';

    /**
     * @return array{int, string}
     */
    public function request(): array
    {
        $this->options['form_params']['output'] = 'xml';
        [$response_code, $body] = $this->client->request('get', self::ENDPOINT, $this->options);

        if ($response_code === 200 && \strpos($body, '<title>Login</title>')) {
            throw new BadRequest('Bad request', 401);
        }

        if ($response_code === 200) {
            return [$response_code, $body];
        }

        throw new BadRequest('Bad request', $response_code);
    }
}
