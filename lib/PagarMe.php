<?php

namespace PagarMe\Sdk;

use GuzzleHttp\Client as GuzzleClient;
use PagarMe\Sdk\Customer\Handler as CustomerHandler;
use PagarMe\Sdk\Transaction\Handler as TransactionHandler;
use PagarMe\Sdk\Card\Handler as CardHandler;

class PagarMe
{
    private $client;
    private $customerHandler;
    private $transactionHandler;
    private $cardHandler;

    public function __construct($apiKey)
    {
        $this->client = new Client(
            new GuzzleClient(['base_url' => 'https://api.pagar.me/1/']),
            $apiKey
        );
    }

    public function customer()
    {
        if (!$this->customerHandler instanceof CustomerHandler) {
            $this->customerHandler = new CustomerHandler($this->client);
        }

        return $this->customerHandler;
    }

    public function transaction()
    {
        if (!$this->transactionHandler instanceof TransactionHandler) {
            $this->transactionHandler = new TransactionHandler($this->client);
        }

        return $this->transactionHandler;
    }

    public function card()
    {
        if (!$this->cardHandler instanceof CardHandler) {
            $this->cardHandler = new CardHandler($this->client);
        }

        return $this->cardHandler;
    }
}
