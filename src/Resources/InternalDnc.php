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

class InternalDnc extends Resource
{
    use WithPhones;

    /**
     * @var string
     */
    private const ENDPOINT = '/app/main/rpc/pdnc';

    private string $body = '';

    private int $response_code;

    public function add(): bool
    {
        return $this->requestExpectNoResponse('add');
    }

    public function remove(): bool
    {
        return $this->requestExpectNoResponse('remove');
    }

    public function count(): int
    {
        $this->options['form_params']['actionType'] = 'count';
        $this->request();
        if ($this->response_code === 200) {
            [$count] = \explode(',', $this->body);
            return (int)$count;
        }

        throw new BadRequest($this->body);
    }

    public function status(): void
    {
        $this->options['form_params']['actionType'] = 'status';
        $this->request();
    }

    public function request(): void
    {
        [$this->response_code, $this->body] = $this->client->request('post', self::ENDPOINT, $this->options);
    }

    private function requestExpectNoResponse(string $type): bool
    {
        if (empty($this->options['form_params']['phoneList'])) {
            throw new BadRequest('No Phone Numbers Requested');
        }

        $this->options['form_params']['actionType'] = $type;
        $this->request();

        if ($this->response_code === 200) {
            return true;
        }

        throw new BadRequest($this->body);
    }
}
