<?php

namespace guardiansdk;

use Psr\Http\Message\ResponseInterface;

class Client
{
    private const DEFAULT_SERVER = 'http://prime.guardianbc.com/';
    private const DEFAULT_TIMEOUT = 3.0;
    private const DEBUG_MODE = false;

    private $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client(
            [
                'base_uri' => getenv('GUARDIAN_SERVER') ?: self::DEFAULT_SERVER,
                'timeout' => getenv('GUARDIAN_TIMEOUT') ?: self::DEFAULT_TIMEOUT,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'debug' => self::DEBUG_MODE
            ]
        );
    }

    public function get(string $uri): ResponseInterface
    {
        return $this->client->get($uri);
    }

    public function post(string $uri, $body): ResponseInterface
    {
        return $this->client->post($uri, ['body' => \GuzzleHttp\json_encode($body)]);
    }
}
