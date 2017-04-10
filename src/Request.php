<?php

namespace CarParser;

use GuzzleHttp\Client;

class Request
{
    /**
     * @var Client
     */
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function exec(Filter $filter, Parser $parser)
    {
        $res = $this->client->request($filter->getMethod(), $filter->getRequestUrl());

        if ($res->getStatusCode() !== 200) {
            throw new \Exception(sprintf('Response code %d, site: %s', $res->getStatusCode(), $filter->getRequestUrl()));
        }

        return $parser->parse($res->getBody()->read(100000000));
    }
}