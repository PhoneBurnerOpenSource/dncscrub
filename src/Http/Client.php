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

namespace PhoneBurner\DNCScrub\Http;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Message;
use PhoneBurner\DNCScrub\Exceptions\BadRequest;
use PhoneBurner\DNCScrub\Exceptions\InvalidArgument;

class Client
{
    public const URL = 'https://www.dncscrub.com';

    private string $login_id;

    private string $project_id;

    private GuzzleClient $client;

    private string $server;

    /**
     * @param array{login_id?:string, project_id?:string, timeout?:float} $config
     */
    public function __construct(
        string $server = '',
        array $config = [],
        ?GuzzleClient $client = null
    ) {
        $this->server = $server ?: self::URL;
        $this->login_id = (string)($config['login_id'] ?? '');
        $this->project_id = (string)($config['project_id'] ?? '');

        if (! $this->login_id) {
            throw new InvalidArgument('Missing login id');
        }

        if (! $this->project_id) {
            throw new InvalidArgument('Missing project id');
        }

        $this->client = $client ?? new GuzzleClient([
            'timeout' => (float)($config['timeout'] ?? 5.0),
        ]);
    }

    /**
     * @param array<string, array<string,mixed>> $options
     * @return array{int, string}
     */
    public function request(string $method, string $endpoint, array $options = []): array
    {
        $options['headers']['loginId'] = $this->login_id;
        $options['form_params']['projId'] = $this->project_id;

        if ($method === 'get') {
            $endpoint .= \strpos($endpoint, '?') ? '&' : '?';
            foreach ($options['form_params'] as $key => $value) {
                $endpoint .= $key . '=' . $value . '&';
            }
        }

        $url = $this->server . $endpoint;

        try {
            $request = $this->client->request($method, $url, $options);
            return [$request->getStatusCode(), (string)$request->getBody()];
        } catch (BadResponseException $e) {
            throw new BadRequest(Message::toString($e->getResponse()), $e->getCode(), $e);
        } catch (Exception $e) {
            throw new BadRequest($e->getMessage(), $e->getCode(), $e);
        }
    }
}
