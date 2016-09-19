<?php

namespace Pagarme\SdkTests\Customer;

use PagarMe\Sdk\Customer\Handler;
use PagarMe\Sdk\Customer\Customer;

class HandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
    **/
    public function mustReturnArrayOfCustomers()
    {
        $clientMock =  $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->getMock();
        $clientMock->method('send')
            ->willReturn(json_decode($this->customerListResponse()));

        $handler = new Handler($clientMock);

        $this->assertContainsOnly(
            'PagarMe\Sdk\Customer\Customer',
            $handler->getList()
        );
    }

    /**
     * @test
    **/
    public function mustReturnCustomers()
    {
        $clientMock =  $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->getMock();
        $clientMock->method('send')
            ->willReturn(json_decode($this->customerGetResponse()));

        $handler = new Handler($clientMock);

        $this->assertInstanceOf(
            'PagarMe\Sdk\Customer\Customer',
            $handler->get(rand(1000, 2000))
        );
    }

    /**
     * @test
    **/
    public function mustReturnCustomerWithId()
    {
        $clientMock =  $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->getMock();
        $clientMock->method('send')
            ->willReturn(json_decode($this->customerGetResponse()));

        $handler = new Handler($clientMock);

        $data = [
            'bornAt' => '15071991',
            'documentNumber' => '44628816808',
            'email' => 'cliente@empresa.com',
            'gender' => 'M',
            'name' => 'João Silva',
            'address' => [
                'street' => 'rua teste',
                'street_number' => 42,
                'neighborhood' => 'centro',
                'zipcode' => '01227200'
            ],
            'phone' => [
                'ddd' => 15,
                'number' => 987523421
            ]
        ];

        $customer = new Customer($data);

        $this->assertInstanceOf(
            'PagarMe\Sdk\Customer\Customer',
            $handler->create($customer)
        );
    }

    private function customerGetResponse()
    {
        return '{"object":"customer","document_number":"18152564000105","document_type":"cnpj","name":"nome do cliente","email":"eee@email.com","born_at":"1970-01-01T03:38:41.988Z","gender":"M","date_created":"2016-09-13T18:04:17.200Z","id":93076,"addresses":[{"object":"address","street":"rua qualquer","complementary":"apto","street_number":"13","neighborhood":"pinheiros","city":"sao paulo","state":"SP","zipcode":"05444040","country":"Brasil","id":45774}],"phones":[{"object":"phone","ddi":"55","ddd":"11","number":"999887766","id":43754}]}';
    }

    private function customerListResponse()
    {
        return sprintf('[%s]', $this->customerGetResponse());
    }
}
