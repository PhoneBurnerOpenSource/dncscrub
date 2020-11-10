<?php

namespace PhoneBurner\DNCScrub;

use PhoneBurner\DNCScrub\Resources\LitigatorScrub;
use PhoneBurner\DNCScrub\Resources\Project;
use PhoneBurner\DNCScrub\Resources\Resource;
use PhoneBurner\DNCScrub\Resources\Scrub;
use PhoneBurner\DNCScrub\Http\Client;
use RuntimeException;

/**
 * Class Factory
 * @method Project project()
 * @method Scrub scrub()
 * @method LitigatorScrub litigatorScrub()
 */
class Factory
{
    protected Client $client;
    protected string $login_id;
    protected string $project_id;

    public function __construct(string $login_id, string $project_id, string $server = '', ?Client $client = null)
    {
        $this->login_id = $login_id;
        $this->project_id = $project_id;
        $server = $server ?: 'https://www.dncscrub.com';

        $this->client = $client ?? new Client($server, [
            'login_id' => $this->login_id,
            'project_id' => $this->project_id
        ]);
    }

    /**
     * Return an instance of a Resource based on the method called.
     */
    public function __call(string $name, ?array $arguments = null): Resource
    {
        $resource = 'PhoneBurner\\DNCScrub\\Resources\\' . ucfirst($name);

        if (class_exists($resource)) {
            return new $resource($this->client, $this->login_id, $this->project_id);
        }

        throw new RuntimeException('Invalid Resource Type');
    }
}
