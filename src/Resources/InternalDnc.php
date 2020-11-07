<?php


namespace PhoneBurner\DNCScrub\Resources;


use PhoneBurner\DNCScrub\Exceptions\BadRequest;

class InternalDnc extends Resource
{
    use WithPhones;

    private const ENDPOINT = '/app/main/rpc/pdnc';
    private string $body = '';
    private int $response_code;

    public function add(): bool
    {
        return $this->requestExpectNoResponse('add');
    }

    public function remove(): bool
    {
        return $this->requestExpectNoResponse('remove');
    }

    public function count(): int
    {
        $this->options['form_params']['actionType'] = 'count';
        $this->request();
        if ($this->response_code === 200) {
            [$count] = explode(',', $this->body);
            return $count;
        }

        throw new BadRequest($this->body);
    }

    public function status(): void
    {
        $this->options['form_params']['actionType'] = 'status';
        $this->request();
    }

    public function request(): void
    {
        [$this->response_code, $this->body] = $this->client->request('post', self::ENDPOINT, $this->options);
    }

     /*
     * @throws BadRequest
     */
    private function requestExpectNoResponse(string $type): bool
    {
        if (empty($this->options['form_params']['phoneList'])) {
            throw new BadRequest('No Phone Numbers Requested');
        }

        $this->options['form_params']['actionType'] = $type;
        $this->request();

        if ($this->response_code === 200) {
            return true;
        }

        throw new BadRequest($this->body);
    }
}