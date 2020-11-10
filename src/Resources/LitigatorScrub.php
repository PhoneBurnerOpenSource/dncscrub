<?php namespace PhoneBurner\DNCScrub\Resources;

use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use PhoneBurner\DNCScrub\Exceptions\BadRequest;

class LitigatorScrub extends Resource
{
    use WithPhones;

    private string $endpoint = '/apiLatest/scrub/litigator';

    private array $results = [];

    /**
     * @throws BadRequest
     * @throws GuzzleException
     * @throws JsonException
     */
    public function request(): array
    {
        $endpoint = $this->endpoint . '?phoneList=' . $this->options['form_params']['phoneList'] . '&version=' . $this->options['form_params']['version'];
        [$response_code, $body] = $this->client->request('get', $endpoint);

        if ((int)$response_code === 200 && strpos($body, '<title>Login</title>')) {
            throw new BadRequest('Bad request', 401);
        }

        if ((int)$response_code === 200) {
            $this->parseBody($body);
            return $this->results;
        }

        throw new BadRequest('Bad request', $response_code);
    }

    private function parseBody(string $body): void
    {
        $rows = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        foreach ($rows as $row) {
            $this->results[$row['Phone']] = (bool)$row['IsLitigator'];
        }
    }
}
