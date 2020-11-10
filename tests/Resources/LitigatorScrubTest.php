<?php

namespace PhoneBurner\DNCScrub\Tests\Resources;

use PhoneBurner\DNCScrub\Exceptions\BadRequest;
use PhoneBurner\DNCScrub\Exceptions\InvalidArgument;
use PhoneBurner\DNCScrub\Http\Client;
use PhoneBurner\DNCScrub\Resources\LitigatorScrub as SUT;
use PHPUnit\Framework\TestCase;

class LitigatorScrubTest extends TestCase
{
    private SUT $sut;
    private string $server = 'https://www.dncscrub.com';

    public function setUp(): void
    {
        parent::setUp();

        $this->sut = new SUT(new Client($this->server, ['login_id' => getenv('DNCSCRUB_LOGIN_ID'), 'project_id' => getenv('DNCSCRUB_PROJECT_ID')]));
    }

    public function testDoesNotAllowEmptyLoginId(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->sut = new SUT(new Client($this->server, ['login_id' => '', 'project_id' => getenv('DNCSCRUB_PROJECT_ID')]));
    }

    public function testDoesNotAllowEmptyProjectId(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->sut = new SUT(new Client($this->server, ['login_id' => getenv('DNCSCRUB_LOGIN_ID'), 'project_id' => '']));
    }

    public function testInvalidLoginIdCausesException(): void
    {
        $this->expectException(BadRequest::class);
        $this->expectExceptionCode(401);
        $sut = new SUT(new Client($this->server, ['login_id' => 'PURPOSELY_BAD_LOGIN_ID_FOR_TESTING', 'project_id' => getenv('DNCSCRUB_PROJECT_ID')]));
        $phone = '8883699131';
        $results = $sut->withPhones([$phone])->request();
    }

    /**
     * @dataProvider phoneNumberDataProvider
     * @param $code
     * @param $phone
     * @throws BadRequest
     */
    public function testScrubNumber($code, $phone): void
    {
        $phones = [$phone];

        $results = $this->sut->withPhones($phones)->request();
        $this->assertEquals($code, $results[$phone]);
    }

    public function phoneNumberDataProvider(): ?\Generator
    {
        yield 'Valid' => [false, '5039367189'];
        yield 'Litigator' => [true, '2675466417'];
    }
}