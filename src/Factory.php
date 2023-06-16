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

namespace PhoneBurner\DNCScrub;

use PhoneBurner\DNCScrub\Http\Client;
use PhoneBurner\DNCScrub\Resources\InternalDnc;
use PhoneBurner\DNCScrub\Resources\LitigatorScrub;
use PhoneBurner\DNCScrub\Resources\Project;
use PhoneBurner\DNCScrub\Resources\Resource;
use PhoneBurner\DNCScrub\Resources\Scrub;
use RuntimeException;

class Factory
{
    private const MAP = [
        'internaldnc' => InternalDnc::class,
        'litigatorscrub' => LitigatorScrub::class,
        'project' => Project::class,
        'scrub' => Scrub::class,
    ];

    public function make(
        string $name,
        string $login_id,
        string $project_id,
        float $timeout = 5.0,
        Client $client = null
    ): Resource {
        $client ??= new Client(Client::URL, [
            'login_id' => $login_id,
            'project_id' => $project_id,
            'timeout' => $timeout,
        ]);

        $resource = self::MAP[\strtolower($name)] ?? null;
        if ($resource !== null) {
            return new $resource($client);
        }

        throw new RuntimeException('Invalid Resource Type');
    }
}
