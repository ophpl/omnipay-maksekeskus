<?php

namespace Omnipay\Maksekeskus\Tests\Message;

use Omnipay\Maksekeskus\Message\PurchaseRequest;
use Omnipay\Maksekeskus\Message\PurchaseResponse;
use Omnipay\Tests\TestCase;

class PurchaseResponseTest extends TestCase
{
    /**
     * @var PurchaseRequest
     */
    protected $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testRedirect()
    {
        $response = new PurchaseResponse(
            $this->request,
            array(
                '_links' => array(
                    'Pay' => array(
                        'href' => 'https://api.maksekeskus.ee/v1/transactions/some-transaction-uuid/payments'
                    ),
                    'self' => array(
                        'href' => 'https://api.maksekeskus.ee/v1/transactions/some-transaction-uuid'
                    )
                ),
                'amount' => 150.25,
                'channel' => null,
                'country' => null,
                'created_at' => "2022-01-01T12:13:00+0000",
                'currency' => "EUR",
                'customer' => array(
                    'created_at' => "2022-01-01T12:13:00+0000",
                    'email' => "test@maksekeskus.ee",
                    'id' => "some-customer-uuid",
                    'ip' => "127.0.0.1",
                    'ip_country' => "ee",
                    'locale' => "en",
                    'name' => "some-name",
                    'object' => "customer",
                ),
                'id' => "some-transaction-uuid",
                'merchant_data' => "Test Transaction Reference",
                'method' => null,
                'object' => "transaction",
                'payment_methods' => array(
                    'banklinks' => array(
                        array(
                            'channel' => "Swedbank EE",
                            'countries' => array(
                                'ee'
                            ),
                            'country' => "ee",
                            'display_name' => "Swedbank",
                            'logo_url' => "https://static.maksekeskus.ee/img/channel/lnd/swedbank.png",
                            'max_amount' => 100000,
                            'name' => "swedbank",
                            'url' => "https://payment.maksekeskus.ee/banklink.html?method=EE_SWED&trx=some-transaction-uuid",
                        )
                    ),
                    'cards' => array(),
                    'other' => array(
                        array(
                            'name' => "redirect",
                            'url' => "https://payment.maksekeskus.ee/pay.html?trx=some-transaction-uuid",
                        )
                    ),
                    'payLater' => array(
                        array(
                            'channel' => "Liisi ID EE",
                            'countries' => array(
                                'ee',
                            ),
                            'country' => "ee",
                            'display_name' => "Liisi ID",
                            'logo_url' => "https://static.maksekeskus.ee/img/channel/lnd/liisi_ee.png",
                            'max_amount' => 100000,
                            'min_amount' => 75,
                            'name' => "liisi_ee",
                            'url' => "https://payment.maksekeskus.ee/pay-later.html?method=EE_LIISI_EE&trx=some-transaction-uuid",
                        ),
                    ),
                ),
                'recurring_required' => false,
                'reference' => "Reference",
                'status' => "CREATED",
                'transaction_url' => array(
                    'cart_url' => null,
                    'return_url' => array(
                        'method' => 'POST',
                        'url' => 'https://www.example.com/return.html'
                    ),
                    'cancel_url' => array(
                        'method' => 'POST',
                        'url' => 'https://www.example.com/cancel.html'
                    ),
                    'notification_url' => array(
                        'method' => 'POST',
                        'url' => 'https://www.example.com/callback.html'
                    )
                ),
                'type' => null,
            ),
            'redirect'
        );

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isCancelled());
        $this->assertFalse($response->isPending());
        $this->assertTrue($response->isRedirect());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertNull($response->getTransactionId());
        $this->assertSame('some-transaction-uuid', $response->getTransactionReference());
        $this->assertSame('https://payment.maksekeskus.ee/pay.html?trx=some-transaction-uuid', $response->getRedirectUrl());
        $this->assertSame('GET', $response->getRedirectMethod());
        $this->assertEmpty($response->getRedirectData());
    }
}
