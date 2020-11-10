<?php namespace PhoneBurner\DNCScrub\Http;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use PhoneBurner\DNCScrub\Exceptions\BadRequest;
use PhoneBurner\DNCScrub\Exceptions\InvalidArgument;
use function GuzzleHttp\Psr7\str;

class Client
{
    private string $login_id;

    private string $project_id;

    private GuzzleClient $client;

    private string $server;

    /**
     * Client constructor.
     * @param string $server
     * @param array $config
     * @param GuzzleClient $client
     * @throws InvalidArgument
     */
    public function __construct(string $server = '', array $config = [], ?GuzzleClient $client = null)
    {
        $this->login_id = $config['login_id'];
        $this->project_id = $config['project_id'];

        if (!$this->login_id) {
            throw new InvalidArgument('Missing login id');
        }

        if (!$this->project_id) {
            throw new InvalidArgument('Missing project id');
        }

        $this->client = $client ?? new GuzzleClient(['timeout' => 5]);
        $this->server = $server ?: 'https://www.dncscrub.com';
    }

    /**
     * @throws BadRequest
     * @throws GuzzleException
     */
    public function request(string $method, string $endpoint, array $options = []): array
    {
        $options['headers']['loginId'] = $this->login_id;
        $options['form_params']['projId'] = $this->project_id;

        if ($method === 'get') {
            $endpoint .= strpos($endpoint, '?') ? '&' : '?';
            foreach ($options['form_params'] as $key => $value) {
                $endpoint .= $key . '=' . $value . '&';
            }
        }
        $url = $this->server . $endpoint;
        try {
            print "$url\n";print_r($options);
            $request = $this->client->request($method, $url, $options);
            return [$request->getStatusCode(), $request->getBody()->getContents()];
        } catch (BadResponseException $e) {
            throw new BadRequest(str($e->getResponse()), $e->getCode(), $e);
        } catch (Exception $e) {
            throw new BadRequest($e->getMessage(), $e->getCode(), $e);
        }
    }
}