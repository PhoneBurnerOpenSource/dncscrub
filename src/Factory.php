<?php

namespace PhoneBurner\DNCScrub;

use PhoneBurner\DNCScrub\Http\Client;
use RuntimeException;

class Factory
{
    public function make(string $name, string $login_id, string $project_id, Client $client = null)
    {
        $server = 'https://www.dncscrub.com';

        $client = $client ?? new Client($server, [
            'login_id' => $login_id,
            'project_id' => $project_id
        ]);

        $resource = 'PhoneBurner\\DNCScrub\\Resources\\' . ucfirst($name);

        if (class_exists($resource)) {
            return new $resource($client, $login_id, $project_id);
        }

        throw new RuntimeException('Invalid Resource Type');
    }
}
