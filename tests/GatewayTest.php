<?php

namespace Omnipay\Maksekeskus\Tests;

use Omnipay\Maksekeskus\Gateway;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /**
     * @var Gateway
     */
    public $gateway;

    public function setUp(): void
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setShopId('shop-id');
        $this->gateway->setKeyPublishable('publishable');
        $this->gateway->setKeySecret('secret');
        $this->gateway->setTestMode(true);
    }

    public function testGateway()
    {
        $this->assertSame('shop-id', $this->gateway->getShopId());
        $this->assertSame('publishable', $this->gateway->getKeyPublishable());
        $this->assertSame('secret', $this->gateway->getKeySecret());
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase();
        $this->assertInstanceOf('Omnipay\Maksekeskus\Message\PurchaseRequest', $request);
    }
}
