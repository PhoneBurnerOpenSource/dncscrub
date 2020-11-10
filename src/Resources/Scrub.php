<?php namespace PhoneBurner\DNCScrub\Resources;

use GuzzleHttp\Exception\GuzzleException;
use PhoneBurner\DNCScrub\Exceptions\BadRequest;
use PhoneBurner\DNCScrub\Result;

class Scrub extends Resource
{
    use WithPhones;

    private const ENDPOINT = '/app/main/rpc/scrub';

    private function parseBody(string $body): array
    {
        $results = [];
        $rows = explode("\n",$body);
        foreach ($rows as $row) {
            if (!$row) {
                continue;
            }
            $result = Result::fromCSV($row);

            $results[$result->getPhone()] = $result;
        }

        return $results;
    }

    /**
     * @throws BadRequest
     * @throws GuzzleException
     */
    public function request(): array
    {
        [$response_code, $body] = $this->client->request('post', self::ENDPOINT, $this->options);

        if ((int)$response_code === 200 && strpos($body, '<title>Login</title>')) {
            throw new BadRequest('Bad request', 401);
        }

        if ((int)$response_code === 200) {
            return $this->parseBody($body);
        }

        throw new BadRequest('Bad request', $response_code);
    }
}
