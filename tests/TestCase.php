<?php

namespace ButtonWallet\Tests;

use ButtonWallet\ButtonWallet;
use Dotenv\Dotenv;
use Symfony\Component\VarDumper\VarDumper;

class TestCase extends \PHPUnit\Framework\TestCase
{


    public $buttonWallet;


    protected function setUp(): void
    {
        parent::setUp();
        $dotEnv = Dotenv::create(dirname(__DIR__) );
        $dotEnv->load();

        $apiKey = getenv('BUTTON_WALLET_TEST_API_KEY');
        if($apiKey === false){
            dd('API Key not set. Please set the API Key in the .env file.');
        }

        $this->buttonWallet = new ButtonWallet($apiKey, true);
    }


    public function tearDown(): void
    {
        $this->buttonWallet = null;
    }
}