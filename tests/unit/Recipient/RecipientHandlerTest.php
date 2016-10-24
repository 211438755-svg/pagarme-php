<?php

namespace Pagarme\SdkTests\Recipient;

use PagarMe\Sdk\Recipient\RecipientHandler;
use PagarMe\Sdk\Recipient\Recipient;

class RecipientHandlerTest extends \PHPUnit_Framework_TestCase
{
    const TRANSFER_INTERVAL = 'weekly';
    const TRANSFER_DAY      = '5';
    const TRANSFER_ENABLED  = true;

    /**
     * @test
    **/
    public function mustReturnCreatedRecipient()
    {
        $bankAccountMock = $this->getMockBuilder('PagarMe\Sdk\Account\Account')
            ->disableOriginalConstructor()
            ->getMock();

        $clientMock =  $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $clientMock->method('send')
            ->willReturn(json_decode('{"object":"recipient","id":"re_ci9bucss300h1zt6dvywufeqc","bank_account":{"object":"bank_account","id":4841,"bank_code":"341","agencia":"0932","agencia_dv":"5","conta":"58054","conta_dv":"1","document_type":"cpf","document_number":"26268738888","legal_name":"API BANK ACCOUNT","charge_transfer_fees":false,"date_created":"2015-03-19T15:40:51.000Z"},"transfer_enabled":true,"last_transfer":null,"transfer_interval":"weekly","transfer_day":5,"automatic_anticipation_enabled":true,"anticipatable_volume_percentage":85,"date_created":"2015-05-05T21:41:48.000Z","date_updated":"2015-05-05T21:41:48.000Z"}'));

        $handler = new RecipientHandler($clientMock);

        $recipient = $handler->create(
            $bankAccountMock,
            self::TRANSFER_INTERVAL,
            self::TRANSFER_DAY,
            self::TRANSFER_ENABLED
        );

        $this->assertInstanceOf(
            'PagarMe\Sdk\Recipient\Recipient',
            $recipient
        );
    }

    /**
     * @test
    **/
    public function mustReturnAnArrayOfRecipients()
    {
        $clientMock =  $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $clientMock->method('send')
            ->willReturn(json_decode($this->recipientsListResponse()));

        $handler = new RecipientHandler($clientMock);
        $recipients = $handler->getList();

        $this->assertContainsOnly(
            'PagarMe\Sdk\Recipient\Recipient',
            $recipients
        );
    }

    /**
     * @test
    **/
    public function mustReturnAnRecipient()
    {
        $clientMock =  $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $clientMock->method('send')
            ->willReturn(json_decode($this->recipientsGetResponse()));

        $handler = new RecipientHandler($clientMock);
        $recipient = $handler->get('re_x1y2z3');

        $this->assertInstanceOf(
            'PagarMe\Sdk\Recipient\Recipient',
            $recipient
        );
    }

    public function recipientsListResponse()
    {
        $response = $this->recipientsGetResponse();
        return sprintf('[%s,%s]', $response, $response);
    }

    public function recipientsGetResponse()
    {
        return '{"object":"recipient","id":"re_x1y2z3","transfer_enabled":true,"last_transfer":null,"transfer_interval":"weekly","transfer_day":5,"automatic_anticipation_enabled":true,"anticipatable_volume_percentage":85,"date_created":"2016-10-17T16:10:11.537Z","date_updated":"2016-10-17T16:10:11.537Z","bank_account":{"object":"bank_account","id":15671961,"bank_code":"000","agencia":"0000","agencia_dv":null,"conta":"00000","conta_dv":"0","document_type":"cnpj","document_number":"00000000000000","legal_name":"CONTA BANCARIA DE TESTES","charge_transfer_fees":true,"date_created":"2016-08-10T10:55:23.545Z"}}';
    }
}
