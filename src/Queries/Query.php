<?php

namespace TeamZac\BluePay\Queries;

use TeamZac\BluePay\Client;

class Query
{
    /** @var Client */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
