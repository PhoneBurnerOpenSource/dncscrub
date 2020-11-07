<?php namespace PhoneBurner\DNCScrub\Resources;

use GuzzleHttp\Exception\GuzzleException;
use PhoneBurner\DNCScrub\Exceptions\BadRequest;

class LitigatorScrub extends Resource
{
    use WithPhones;

    private $endpoint = '/apiLatest/scrub/litigator';
    private $valid_response = false;
    private $results;

    /**
     * @throws BadRequest
     * @throws GuzzleException
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

    private function parseBody($body)
    {
        $this->valid_response = true;
        $rows = json_decode($body);
        foreach ($rows as $row) {
            $this->results[$row->Phone] = $row->IsLitigator;
        }
    }
}
