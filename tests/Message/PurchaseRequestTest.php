<?php

namespace Omnipay\Maksekeskus\Tests\Message;

use Omnipay\Maksekeskus\Message\PurchaseRequest;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    /**
     * @var PurchaseRequest
     */
    private $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array(
            'username' => 'merchant',
            'secret' => 'secret',
            'accounts' => array(
                array(
                    'name' => 'euro-account-name',
                    'currency' => 'EUR'
                )
            ),
            'amount'        => 15.34,
            'currency'      => 'EUR',
            'transactionId' => 'T12345',
            'description'   => 'Test',
            'clientIp'      => '127.0.0.1',
            'returnUrl'     => 'https://www.example.com/return.html',
            'cancelUrl'     => 'https://www.example.com/cancel.html',
            'notifyUrl'     => 'https://www.example.com/notify.html',
            'card' => array(
                'email' => 'test@maksekeskus.ee'
            )
        ));
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame('15.34', $data['transaction']['amount']);
        $this->assertSame('T12345', $data['transaction']['reference']);
        $this->assertSame('test@maksekeskus.ee', $data['customer']['email']);
    }
}
