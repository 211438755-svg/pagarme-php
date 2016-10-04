<?php

namespace PagarMe\Sdk\Transaction;

class CreditCardTransaction extends Transaction
{
    const PAYMENT_METHOD = 'credit_card';

    protected $card;
    protected $installments;
    protected $capture;

    public function __construct($transactionData)
    {
        parent::__construct($transactionData);
        $this->paymentMethod = self::PAYMENT_METHOD;
    }

    public function getCardId()
    {
        return $this->card->getId();
    }

    public function getInstallments()
    {
        return $this->installments;
    }

    public function isCapturable()
    {
        return (bool) $this->capture;
    }
}
