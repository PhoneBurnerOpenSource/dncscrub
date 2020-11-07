<?php

namespace PhoneBurner\DNCScrub\Resources;

use PhoneBurner\DNCScrub\Http\Client;

abstract class Resource
{
    protected Client $client;
    protected array $options = [];

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->options['form_params']['version'] = 3;
    }

    abstract public function request();
}