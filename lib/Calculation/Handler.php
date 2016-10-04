<?php

namespace PagarMe\Sdk\Calculation;

use PagarMe\Sdk\Client;
use PagarMe\Sdk\Calculation\Request\CalculateInstallmentsRequest;

class Handler
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function calculateInstallmentsAmount(
        $amount,
        $interestRate,
        $freeInstallments = 1,
        $maxInstallments = 12
    ) {
        $request = new CalculateInstallmentsRequest(
            $amount,
            $interestRate,
            $freeInstallments,
            $maxInstallments
        );

        $result = $this->client->send($request);

        $installments = [];
        foreach ($result->installments as $key => $value) {
            $installments[$key] = [
                'installment_amount' => $value->installment_amount,
                'total_amount' => $value->amount
            ];
        }

        return $installments;
    }
}
