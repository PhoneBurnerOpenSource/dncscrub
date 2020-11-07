<?php

namespace PhoneBurner\DNCScrub\Tests\Resources;

use PhoneBurner\DNCScrub\Exceptions\BadRequest;
use PhoneBurner\DNCScrub\Exceptions\InvalidArgument;
use PhoneBurner\DNCScrub\Http\Client;
use PhoneBurner\DNCScrub\Resources\Scrub;
use PhoneBurner\DNCScrub\Result\C;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

class ScrubTest extends TestCase
{
    use ProphecyTrait;

    private Scrub $scrub;
    private string $server = 'https://www.dncscrub.com';

    /**
     * @var Client|ObjectProphecy
     */
    private $client;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = $this->prophesize(Client::class);

        #$this->scrub = new Scrub(new Client($this->server, ['login_id' => getenv('DNCSCRUB_LOGIN_ID'), 'project_id' => getenv('DNCSCRUB_PROJECT_ID')]));
        $this->scrub = new Scrub($this->client->reveal());
    }

    public function testDoesNotAllowEmptyLoginId(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->scrub = new Scrub(new Client($this->server, ['login_id' => '', 'project_id' => getenv('DNCSCRUB_PROJECT_ID')]));
    }

    public function testDoesNotAllowEmptyProjectId(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->scrub = new Scrub(new Client($this->server, ['login_id' => getenv('DNCSCRUB_LOGIN_ID'), 'project_id' => '']));
    }

    public function testInvalidLoginIdCausesException(): void
    {
        $this->expectException(BadRequest::class);
        $this->expectExceptionCode(401);
        $scrub = new Scrub(new Client($this->server, ['login_id' => 'PURPOSELY_BAD_LOGIN_ID_FOR_TESTING', 'project_id' => getenv('DNCSCRUB_PROJECT_ID')]));
        $phone = '8883699131';
        $scrub->withPhones([$phone])->request();
    }

    public function testScrubNumber(): void
    {
        $phone = '8883699132';
        $this->client->request(Argument::cetera())->willReturn([
            200, "$phone,C,,;;;W,CA,US,Canoga Park,981E;CLEC;\"Bandwidth.com CLEC LLC:Bandwidth.com\",,4,,-420,,4",
        ]);
        $results = $this->scrub->withPhones([$phone])->request();
        self::assertInstanceOf(C::class, $results[$phone]->getResultCode());
    }
}