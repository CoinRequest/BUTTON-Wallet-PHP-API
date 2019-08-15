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
        $description = "\nTest from *CoinRequest.io*!\n";

        try {
            $response = $this->buttonWallet->linkEndpoint()->getLink($amount, $address, $tokenAddress, $amountInUsd,
                $currency, $description);

            $link = $response[0];

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
        $description = "\nTest from *CoinRequest.io*!\n";

        try {
            $response = $this->buttonWallet->linkEndpoint()->getLink($amount, $address, $tokenAddress, $amountInUsd,
                $currency, $description);

            $link = $response[0];

            $this->assertStringContainsString('https://t.me/wallet_test_bot', $link);

        } catch (GuzzleException $e) {
            $this->assertEquals(true, false);
        }


    }
}