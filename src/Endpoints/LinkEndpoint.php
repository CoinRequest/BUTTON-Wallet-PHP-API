<?php

namespace ButtonWallet\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class LinkEndpoint extends BaseEndpoint
{

    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->endpoint = 'FastLink/';
    }


    /**
     * Generates a link/URI which can be used to open the ButtonWallet Telegram Bot.
     *
     * Example Request with DAI:
     * {
     *     "currency": null,
     *     "amount": 2,
     *     "address": "0xb341c20c37573bd0ab3e69b063e535635f4710f8",
     *     "tokenAddress": "0x89d24a6b4ccb1b6faa2625fe562bdd9a23260359",
     *     "amountInUsd": true,
     *     "webHookUrl": "https://exampleapp.io/webhook",
     *     "description": "\nTest from *CoinRequest.io*!\n"
     * }
     *
     * Success Response structure:
     *
     * {
     *    "uuid": "1234567890abcdefg",
     *    "botlink": "https://t.me/wallet_test_bot?start=1234567890abcdefg"
     * }
     *
     * @param integer $amount       Amount to request. Can be in USD or Coin amount. Please see $amountInUsd boolean.
     * @param string  $address      Address of the wallet
     * @param string  $tokenAddress Address of the coin. For example an contract address of an ERC20 token. Can be null.
     * @param boolean $amountInUsd  If true, the amount is calculated in USD
     * @param string  $webHookUrl   URL which will be called with a POST request as a callback
     * @param string  $currency     The ticker of the coin. Can be null. Example: BTC
     * @param string  $description  Description of the request. Can be null
     *
     * @return array
     * @throws GuzzleException
     */
    public function createLink(
        $amount,
        $address,
        $tokenAddress,
        $amountInUsd,
        $webHookUrl = null,
        $currency = null,
        $description = null
    ) {
        $params = [
            'body' => json_encode([
                'currency'     => $currency,
                'amount'       => $amount,
                'address'      => $address,
                'tokenAddress' => $tokenAddress,
                'amountInUsd'  => $amountInUsd,
                'webhookUrl'   => $webHookUrl,
                'description'  => $description

            ])
        ];

        return $this->post($this->endpoint.'create', $params);

    }


    /**
     * Returns an array of all generated links.
     *
     * Example Response:
     *
     * {
     *     "linksInfo": [
     *       {
     *         "uuid": "84a81bfdb60",
     *         "currency": "ETH",
     *         "amount": 2.0,
     *         "address": "0xb341c20c37573bd0ab3e69b063e535635f4710f8",
     *         "tokenAddress": null,
     *         "amountInUsd": true,
     *         "description": "\nTest Description*!\n",
     *         "webHookUrl": "",
     *         "isWebHookSet": false
     *       },
     *       {
     *         "uuid": "2b168a24d109514220",
     *         "currency": "ETH",
     *         "amount": 0.22,
     *         "address": "0xb341c20c37573bd0ab3e69b063e535635f4710f8",
     *         "tokenAddress": null,
     *         "amountInUsd": true,
     *         "description": "\nTest Description*!\n",
     *         "webHookUrl": "",
     *         "isWebHookSet": false
     *
     *       }
     *     ],
     *     "tokenTransactionsInfo": [
     *       {
     *          "guid": "e2b0a22fb14504567",
     *          "currency": "Dai Stablecoin v1.0",
     *          "from": "0xb341c20c37573bd0ab3e69b063e535635f4710f8",
     *          "to": "0xb341c20c37573bd0ab3e69b063e535635f4710f8",
     *          "tokenAddress": "0x89d24a6b4ccb1b6faa2625fe562bdd9a23260359",
     *          "value": "0.099403578528827037773359841",
     *          "valueInUsd": "0.1",
     *          "txHash": "0x10a08d7a2cee609cc05b4cbff9aa1ab796d8d017eb9f5fb3f9da179075cf9835",
     *          "createdAt": "2019-08-19T05:12:40.946912+00:00"
     *       }
     *     ],
     *     "currencyTransactionsInfo": [
     *       {
     *          "guid": "147481b9877859078",
     *          "currency": "Ethereum",
     *          "from": "0xb341c20c37573bd0ab3e69b063e535635f4710f8",
     *          "to": "0xb341c20c37573bd0ab3e69b063e535635f4710f8",
     *          "tokenAddress": "",
     *          "value": "0.000511901714871",
     *          "valueInUsd": "0.1",
     *          "txHash": "0xb3bd611f05a2a58155ff97c5a2e18529c986b1e1c2278a49911a516088fd4ec4",
     *          "createdAt": "2019-08-19T05:04:18.151878+00:00"
     *       },
     *       {
     *          "guid": "90349de9b13630",
     *          "currency": "Ethereum",
     *          "from": "0xb341c20c37573bd0ab3e69b063e535635f4710f8",
     *          "to": "0xb341c20c37573bd0ab3e69b063e535635f4710f8",
     *          "tokenAddress": "",
     *          "value": "0.000511901714871",
     *          "valueInUsd": "0.1",
     *          "txHash": "0x6a005db83d539fc8d841a2fc4c946bf0def40f54c178e3f61dcfad02383a9874",
     *          "createdAt": "2019-08-19T05:05:38.346813+00:00"
     *       }
     *     ]
     * }
     *
     * @return array
     * @throws GuzzleException
     */
    public function getAll()
    {
        return $this->get($this->endpoint.'readAll', null);
    }


    /**
     * Gets info for a created link.
     *
     * Success Response structure:
     *
     * {
     *    "currency": "",
     *    "amount": 0.1,
     *    "address": "0xb341c20c37573bd0ab3e69b063e535635f4710f8",
     *    "tokenAddress": "0x89d24a6b4ccb1b6faa2625fe562bdd9a23260359",
     *    "amountInUsd": true,
     *    "webHookUrl": "https://exampleapp.io/webhook",
     *    "description": "\nTest Description\n"
     * }
     *
     * @param string $uuid
     *
     * @return array
     * @throws GuzzleException
     */
    public function getLinkInfoByUuid($uuid)
    {
        return $this->get($this->endpoint.'readInfoByUuid/'.$uuid, null);
    }


    /**
     * Gets transaction info for a created link.
     *
     * Success Response structure:
     *
     * {
     *    "linksInfo": {
     *        "uuid": "d34ace31c10251",
     *        "currency": "ETH",
     *        "amount": 0.1,
     *        "address": "0xb341c20c37573bd0ab3e69b063e535635f4710f8",
     *        "tokenAddress": null,
     *        "amountInUsd": true,
     *        "description": "\nTest Description\n",
     *        "webHookUrl": "https://exampleapp.io/webhook",
     *        "isWebHookSet": true
     *    },
     *    "tokenTransactionsInfo": [],
     *    "currencyTransactionsInfo": [
     *      {
     *        "guid": "d34ace31c10251",
     *        "currency": "Ethereum",
     *        "from": "0xb341c20c37573bd0ab3e69b063e535635f4710f8",
     *        "to": "0xb341c20c37573bd0ab3e69b063e535635f4710f8",
     *        "tokenAddress": "",
     *        "value": "0.000511901714871",
     *        "valueInUsd": "0.1",
     *        "txHash": "0x9269470a6a3bf7b4418622c07dc8311785cbec5dbe023838b63a27cecd28e64d",
     *        "createdAt": "2019-08-19T05:07:30.364662+00:00"
     *      }
     *    ]
     * }
     *
     * @param string $uuid
     *
     * @return array
     * @throws GuzzleException
     */
    public function getTransactionInfoByUuid($uuid)
    {
        return $this->get($this->endpoint.'readByUuid/'.$uuid, null);
    }


    /**
     * Gets info about the set WebHook for a created link.
     *
     * Success Response structure:
     *
     * {
     *    "url": "https://exampleapp.io/webhook",
     *    "isSet": true,
     *    "transactionInfo": {
     *         "uuid": "03aba02c6384",
     *         "currency": "ETH",
     *         "amount": 2.0,
     *         "address": "0xb341c20c37573bd0ab3e69b063e535635f4710f8",
     *         "tokenAddress": null,
     *         "amountInUsd": true,
     *         "description": "\nTest Description\n",
     *         "webHookUrl": "https://exampleapp.io/webhook",
     *         "isWebHookSet": true
     *    }
     * }
     *
     * @param string $uuid
     *
     * @return array
     * @throws GuzzleException
     */
    public function getWebHookInfoByUuid($uuid)
    {
        return $this->get($this->endpoint.'webhook/'.$uuid, null);
    }


    /**
     * Sets the WebHook for a generated link.
     *
     * Example Request with DAI:
     * {
     *     "url": "https://exampleapp.io/webhook",
     * }
     *
     * Success Response structure:
     *
     * {
     *    "url": "https://exampleapp.io/webhook",
     *    "isSet": true,
     *    "transactionInfo": {
     *    "uuid": "d34ace31c10251",
     *    "currency": "ETH",
     *    "amount": 0.1,
     *    "address": "0xb341c20c37573bd0ab3e69b063e535635f4710f8",
     *    "tokenAddress": null,
     *    "amountInUsd": true,
     *    "description": "\nTest Description\n",
     *    "webHookUrl": "https://exampleapp.io/webhook",
     *    "isWebHookSet": true
     * }
     * }
     *
     * @param string $uuid
     * @param string $webHookUrl URL which will be called with a POST request as a callback
     *
     * @return array
     * @throws GuzzleException
     */
    public function setWebHookByUuid($uuid, $webHookUrl)
    {
        $params = [
            'body' => json_encode([
                'url' => $webHookUrl,
            ])
        ];

        return $this->post($this->endpoint.'webhook/set/'.$uuid, $params);
    }

}