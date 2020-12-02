<?php namespace PhoneBurner\DNCScrub\Resources;

use PhoneBurner\DNCScrub\Exceptions\BadRequest;

class Project extends Resource
{
    private const ENDPOINT = '/app/main/rpc/project';

    public function request()
    {
        $this->options['form_params']['output'] = 'xml';
        [$response_code, $body] = $this->client->request('get', self::ENDPOINT, $this->options);

        if ((int)$response_code === 200 && strpos($body, '<title>Login</title>')) {
            throw new BadRequest('Bad request', 401);
        }

        if ((int)$response_code === 200) {
            return [$response_code, $body];
        }

        throw new BadRequest('Bad request', $response_code);
    }
}
