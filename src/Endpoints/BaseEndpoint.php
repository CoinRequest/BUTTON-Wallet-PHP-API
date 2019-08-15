<?php

namespace ButtonWallet\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class BaseEndpoint
{

    /**
     * @var Client
     */
    private $client;

    protected $endpoint;


    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    /**
     * @param string $url
     * @param null   $params
     *
     * @return array
     * @throws GuzzleException
     */
    protected function get($url = '/', $params = null) {
        if(!is_array($params)){
            $params = [];
        }
        $response = $this->client->request('GET', $url, $params);
        return $this->responseFromJson($response);
    }

    /**
     * @param string $url
     * @param null   $params
     *
     * @return array
     * @throws GuzzleException
     */
    protected function post($url = '/', $params = null) {
        if(!is_array($params)){
            $params = [];
        }
        $response = $this->client->request('POST', $url, $params);
        return $this->responseFromJson($response);
    }

    /**
     * @param ResponseInterface $response
     *
     * @return array
     */
    private function responseFromJson(ResponseInterface $response): array {
        return (array) json_decode($response->getBody());
    }
}