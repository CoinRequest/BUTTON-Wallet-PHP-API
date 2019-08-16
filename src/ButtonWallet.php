<?php

namespace ButtonWallet;

use ButtonWallet\Endpoints\LinkEndpoint;
use Composer\CaBundle\CaBundle;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class ButtonWallet
{

    private $client;

    private $linkEndpoint;

    public static $API_ROUTE = 'https://client.buttonwallet.com/api/';

    public static $TIMEOUT = 10.0;


    public function __construct($apiKey, $testMode = false)
    {

        if ($testMode) {
            self::$API_ROUTE = 'https://client.buttonwallet.tech/api/';
        }

        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri'              => self::$API_ROUTE,
            // You can set any number of default request options.
            RequestOptions::TIMEOUT => self::$TIMEOUT,
            RequestOptions::VERIFY  => CaBundle::getBundledCaBundlePath(),
            'headers'               => [
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
                'Authorization' => $apiKey
            ]
        ]);
    }


    /**
     * @return LinkEndpoint
     */
    public function linkEndpoint(): LinkEndpoint
    {
        if ( ! isset($this->linkEndpoint) || is_null($this->linkEndpoint)) {
            $this->setLinkEndPoint(new LinkEndpoint($this->client));
        }

        return $this->linkEndpoint;
    }


    /**
     * @param LinkEndpoint $linkEndpoint
     */
    private function setLinkEndPoint(LinkEndpoint $linkEndpoint)
    {
        $this->linkEndpoint = $linkEndpoint;
    }

}