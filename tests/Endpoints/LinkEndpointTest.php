<?php

namespace ButtonWallet\Tests\Endpoints;

use ButtonWallet\Tests\TestCase;
use GuzzleHttp\Exception\GuzzleException;

class LinkEndpointTest extends TestCase
{

    /**
     * @test
     */
    function it_should_be_able_to_generate_a_link_for_a_coin()
    {
        $currency = 'ETH';
        $amount = '2.0000022';
        $address = "0xb341c20c37573bd0ab3e69b063e535635f4710f8";
        $tokenAddress = null;
        $amountInUsd = false;
        $webHook = null;
        $description = "\nTest from *CoinRequest.io*!\n";

        try {
            $response = $this->buttonWallet->linkEndpoint()->createLink($amount, $address, $tokenAddress, $amountInUsd,
                $webHook, $currency, $description);

            $link = $response['botLink'];

            $this->assertStringContainsString('https://t.me/wallet_test_bot', $link);

        } catch (GuzzleException $e) {
            $this->assertEquals(true, false);
        }


    }


    /**
     * @test
     */
    function it_should_be_able_to_generate_a_link_for_a_token()
    {
        $currency = null;
        $amount = 2;
        $address = "0xb341c20c37573bd0ab3e69b063e535635f4710f8";
        $tokenAddress = "0x89d24a6b4ccb1b6faa2625fe562bdd9a23260359";
        $amountInUsd = true;
        $webHook = null;
        $description = "\nTest from *CoinRequest.io*!\n";

        try {
            $response = $this->buttonWallet->linkEndpoint()->createLink($amount, $address, $tokenAddress, $amountInUsd,
                $webHook,$currency, $description);

            $link = $response['botLink'];

            $this->assertStringContainsString('https://t.me/wallet_test_bot', $link);

        } catch (GuzzleException $e) {
            $this->assertEquals(true, false);
        }
    }


    /**
     * @test
     */
    function it_should_be_able_to_get_all_links()
    {

        try {
            $response = $this->buttonWallet->linkEndpoint()->getAll();

            $this->assertTrue(isset($response['linksInfo']));
            $this->assertTrue(isset($response['tokenTransactionsInfo']));
            $this->assertTrue(isset($response['currencyTransactionsInfo']));

        } catch (GuzzleException $e) {
            $this->assertEquals(true, false);
        }
    }


    /**
     * @test
     */
    function it_should_be_able_to_get_the_info_of_a_created_link_by_uuid()
    {
        $currency = 'ETH';
        $amount = '2.0000022';
        $address = "0xb341c20c37573bd0ab3e69b063e535635f4710f8";
        $tokenAddress = null;
        $amountInUsd = false;
        $webHook = 'https://exampleapp.io/webhook';
        $description = "\nTest from *CoinRequest.io*!\n";

        try {
            $response = $this->buttonWallet->linkEndpoint()->createLink($amount, $address, $tokenAddress, $amountInUsd,
                $webHook,$currency, $description);

            $uuid = $response['uuid'];

            try {
                $infoResponse = $this->buttonWallet->linkEndpoint()->getLinkInfoByUuid($uuid);
                $this->assertEquals($infoResponse['address'], $address);
                $this->assertEquals($infoResponse['webHookUrl'], $webHook);

            } catch (GuzzleException $e) {
                $this->assertEquals(true, false);
            }
        } catch (GuzzleException $e) {
            $this->assertEquals(true, false);
        }
    }

    /**
     * @test
     */
    function it_should_be_able_to_get_the_transaction_info_of_a_created_link_by_uuid()
    {
        $currency = 'ETH';
        $amount = '2.0000022';
        $address = "0xb341c20c37573bd0ab3e69b063e535635f4710f8";
        $tokenAddress = null;
        $amountInUsd = false;
        $webHook = 'https://exampleapp.io/webhook';
        $description = "\nTest from *CoinRequest.io*!\n";

        try {
            $response = $this->buttonWallet->linkEndpoint()->createLink($amount, $address, $tokenAddress, $amountInUsd,
                $webHook,$currency, $description);

            $uuid = $response['uuid'];

            try {
                $transactionInfo = $this->buttonWallet->linkEndpoint()->getTransactionInfoByUuid($uuid);
                $this->assertTrue(isset($transactionInfo['linksInfo']));
                $this->assertTrue(isset($transactionInfo['tokenTransactionsInfo']));
                $this->assertTrue(isset($transactionInfo['currencyTransactionsInfo']));

            } catch (GuzzleException $e) {
                $this->assertEquals(true, false);
            }
        } catch (GuzzleException $e) {
            $this->assertEquals(true, false);
        }
    }

    /**
     * @test
     */
    function it_should_be_able_to_get_the_web_hook_info_of_a_created_link_by_uuid()
    {
        $currency = 'ETH';
        $amount = '2.0000022';
        $address = "0xb341c20c37573bd0ab3e69b063e535635f4710f8";
        $tokenAddress = null;
        $amountInUsd = false;
        $webHook = 'https://exampleapp.io/webhook';
        $description = "\nTest from *CoinRequest.io*!\n";

        try {
            $response = $this->buttonWallet->linkEndpoint()->createLink($amount, $address, $tokenAddress, $amountInUsd,
                $webHook,$currency, $description);

            $uuid = $response['uuid'];

            try {
                $webHookInfo = $this->buttonWallet->linkEndpoint()->getWebHookInfoByUuid($uuid);
                $this->assertEquals($webHookInfo['url'], $webHook);
                $this->assertTrue(isset($webHookInfo['transactionInfo']));

            } catch (GuzzleException $e) {
                $this->assertEquals(true, false);
            }
        } catch (GuzzleException $e) {
            $this->assertEquals(true, false);
        }
    }


    /**
     * @test
     */
    function it_should_be_able_to_set_the_web_hook_for_a_created_link()
    {
        $currency = 'ETH';
        $amount = '2.0000022';
        $address = "0xb341c20c37573bd0ab3e69b063e535635f4710f8";
        $tokenAddress = null;
        $amountInUsd = false;
        $webHook = null;
        $description = "\nTest from *CoinRequest.io*!\n";

        try {
            $response = $this->buttonWallet->linkEndpoint()->createLink($amount, $address, $tokenAddress, $amountInUsd,
                $webHook,$currency, $description);

            $uuid = $response['uuid'];

            try {
                $webHook = 'https://exampleapp.io/webhook';
                $webHookSetResponse = $this->buttonWallet->linkEndpoint()->setWebHookByUuid($uuid, $webHook);
                $this->assertEquals($webHookSetResponse['url'], $webHook);
                $this->assertTrue(isset($webHookSetResponse['transactionInfo']));
                $this->assertTrue($webHookSetResponse['transactionInfo']->isWebHookSet);

            } catch (GuzzleException $e) {
                dd($e);
                $this->assertEquals(true, false);
            }
        } catch (GuzzleException $e) {
            $this->assertEquals(true, false);
        }
    }
}