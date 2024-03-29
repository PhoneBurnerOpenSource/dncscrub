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

namespace PhoneBurner\Tests\DNCScrub\Resources;

use PhoneBurner\DNCScrub\Exceptions\BadRequest;
use PhoneBurner\DNCScrub\Exceptions\InvalidArgument;
use PhoneBurner\DNCScrub\Http\Client;
use PhoneBurner\DNCScrub\Resources\Project;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

class ProjectTest extends TestCase
{
    use ProphecyTrait;

    private Project $project;

    private string $server = 'https://www.dncscrub.com';

    /**
     * @var ObjectProphecy<Client>
     */
    private ObjectProphecy $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = $this->prophesize(Client::class);

        $this->project = new Project(new Client($this->server, [
            'login_id' => 'DNCSCRUB_LOGIN_ID',
            'project_id' => 'DNCSCRUB_PROJECT_ID',
        ]));
    }

    public function testDoesNotAllowEmptyLoginId(): void
    {
        $this->expectException(InvalidArgument::class);
        new Project(new Client($this->server, [
            'login_id' => '',
            'project_id' => 'DNCSCRUB_PROJECT_ID',
        ]));
    }

    public function testDoesNotAllowEmptyProjectId(): void
    {
        $this->expectException(InvalidArgument::class);
        new Project(new Client($this->server, [
            'login_id' => 'DNCSCRUB_LOGIN_ID',
            'project_id' => '',
        ]));
    }

    public function testInvalidLoginIdCausesException(): void
    {
        $this->expectException(BadRequest::class);
        $this->expectExceptionCode(401);
        $project = new Project(new Client($this->server, [
            'login_id' => 'PURPOSELY_BAD_LOGIN_ID_FOR_TESTING',
            'project_id' => 'DNCSCRUB_PROJECT_ID',
        ]));
        $project->request();
    }

    /** @test */
    public function it_can_get_project_settings(): void
    {
        $phone = '8883699132';
        $this->client->request(Argument::cetera())->willReturn([
            200,
            \sprintf('%s,C,,;;;W,CA,US,Canoga Park,981E;CLEC;"Bandwidth.com CLEC LLC:Bandwidth.com",,4,,-420,,4', $phone),
        ]);
        $this->project->request();
    }
}
