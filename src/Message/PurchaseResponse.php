<?php

namespace Omnipay\Maksekeskus\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * @var string $paymentMethod payment method
     */
    protected $paymentMethod;

    /**
     * Constructor
     *
     * @param RequestInterface $request the initiating request.
     * @param mixed $data
     */
    public function __construct(RequestInterface $request, $data, $paymentMethod)
    {
        parent::__construct($request, $data);
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * {@inheritDoc}
     */
    public function isSuccessful()
    {
        // Return false to indicate that more actions are needed to complete the transaction.
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function isRedirect()
    {
        // search for preferred payment method
        foreach ($this->data['payment_methods'] as $methods) {
            foreach ($methods as $method) {
                if ($method['name'] == $this->paymentMethod) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function getRedirectUrl()
    {
        foreach ($this->data['payment_methods'] as $methods) {
            foreach ($methods as $method) {
                if ($method['name'] == $this->paymentMethod) {
                    return $method['url'];
                }
            }
        }

        return '';
    }

    /**
     * {@inheritDoc}
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }

    /**
     * {@inheritDoc}
     */
    public function getTransactionReference()
    {
        return $this->data['id'];
    }
}
