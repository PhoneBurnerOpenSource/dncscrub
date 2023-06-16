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
use PhoneBurner\DNCScrub\Resources\LitigatorScrub as SUT;
use PHPUnit\Framework\TestCase;

class LitigatorScrubTest extends TestCase
{
    private SUT $sut;

    private string $server = 'https://api.dncscrub.com';

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new SUT(new Client($this->server, [
            'login_id' => (string)\getenv('DNCSCRUB_LOGIN_ID'),
            'project_id' => (string)\getenv('DNCSCRUB_PROJECT_ID'),
        ]));
    }

    public function testDoesNotAllowEmptyLoginId(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->sut = new SUT(new Client($this->server, [
            'login_id' => '',
            'project_id' => 'DNCSCRUB_PROJECT_ID',
        ]));
    }

    public function testDoesNotAllowEmptyProjectId(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->sut = new SUT(new Client($this->server, [
            'login_id' => 'DNCSCRUB_LOGIN_ID',
            'project_id' => '',
        ]));
    }

    public function testInvalidLoginIdCausesException(): void
    {
        $this->expectException(BadRequest::class);
        $this->expectExceptionCode(401);
        $sut = new SUT(new Client($this->server, [
            'login_id' => 'PURPOSELY_BAD_LOGIN_ID_FOR_TESTING',
            'project_id' => 'DNCSCRUB_PROJECT_ID',
        ]));
        $phone = '8883699131';
        $sut->withPhones([$phone])->request();
    }

    /**
     * @dataProvider phoneNumberDataProvider
     */
    public function testScrubNumber(bool $code, string $phone): void
    {
        $phones = [$phone];

        $results = $this->sut->withPhones($phones)->request();
        self::assertEquals($code, $results[$phone]);
    }

    public function phoneNumberDataProvider(): \Generator
    {
        yield 'Valid' => [false, '5039367189'];
        yield 'Litigator' => [true, '2675466417'];
    }
}
