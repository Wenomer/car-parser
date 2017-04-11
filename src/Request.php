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

    public function exec($settings)
    {
        $params = isset($settings['params']) ? $settings['params'] : [];
        $res = $this->client->request($settings['method'], $settings['url'], $params);

        if ($res->getStatusCode() !== 200) {
            throw new \Exception(sprintf('Response code %d, site: %s', $res->getStatusCode(), $settings['url']));
        }

        return $res->getBody()->getContents();
    }
}