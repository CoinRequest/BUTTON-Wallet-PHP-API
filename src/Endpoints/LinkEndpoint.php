<?php

namespace ButtonWallet\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class LinkEndpoint extends BaseEndpoint
{

    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->endpoint = 'FastLink';
    }


    /**
     * Generates a link/URI which can be used to open the ButtonWallet Telegram Bot.
     *
     * Example Example with DAI:
     * {
     * "currency": null,
     * "amount": 2,
     * "address": "0xb341c20c37573bd0ab3e69b063e535635f4710f8",
     * "tokenAddress": "0x89d24a6b4ccb1b6faa2625fe562bdd9a23260359",
     * "amountInUsd": true,
     * "description": "\nTest from *CoinRequest.io*!\n"
     * }
     *
     * @param integer $amount       Amount to request. Can be in USD or Coin amount. Please see $amountInUsd boolean.
     * @param string  $address      Address of the wallet
     * @param string  $tokenAddress Address of the coin. For example an contract address of an ERC20 token. Can be null.
     * @param boolean $amountInUsd  If true, the amount is calculated in USD
     * @param string  $currency     The ticker of the coin. Can be null. Example: BTC
     * @param string  $description  Description of the request. Can be null
     *
     * @return array
     * @throws GuzzleException
     */
    public function getLink($amount, $address, $tokenAddress, $amountInUsd, $currency = null, $description = null)
    {
        $params = [
            'body' => json_encode([
                'currency'     => $currency,
                'amount'       => $amount,
                'address'      => $address,
                'tokenAddress' => $tokenAddress,
                'amountInUsd'  => $amountInUsd,
                'description'  => $description

            ])
        ];

        return $this->post($this->endpoint, $params);

    }
}