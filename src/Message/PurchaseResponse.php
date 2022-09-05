<?php

namespace Omnipay\Maksekeskus\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    public const REDIRECT_PAYMENT_METHOD = 'redirect';

    /**
     * Preferred payment method, if not set then will default to redirect.
     *
     * @var string $paymentMethod payment method
     */
    protected $paymentMethod;

    /**
     * Constructor
     *
     * @param RequestInterface $request the initiating request.
     * @param mixed $data
     * @param string $paymentMethod preferred payment method
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
        $preferredPaymentMethod = $this->getPaymentMethodFromData($this->paymentMethod);

        if (!empty($preferredPaymentMethod)) {
            return true;
        }

        // preferred not found, search for redirect
        $fallbackPaymentMethod = $this->getPaymentMethodFromData(self::REDIRECT_PAYMENT_METHOD);

        if (!empty($fallbackPaymentMethod)) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function getRedirectUrl()
    {
        // search for preferred payment method
        $preferredPaymentMethod = $this->getPaymentMethodFromData($this->paymentMethod);

        if (!empty($preferredPaymentMethod)) {
            return $preferredPaymentMethod['url'];
        }

        // preferred not found, search for redirect
        $fallbackPaymentMethod = $this->getPaymentMethodFromData(self::REDIRECT_PAYMENT_METHOD);

        if (!empty($fallbackPaymentMethod)) {
            return $fallbackPaymentMethod['url'];
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

    /**
     * Get payment method.
     *
     * @param string $paymentMethod payment method name
     * @return mixed|null
     */
    protected function getPaymentMethodFromData($paymentMethod)
    {
        // search for preferred payment method
        foreach ($this->data['payment_methods'] as $methods) {
            foreach ($methods as $method) {
                if ($method['name'] == $paymentMethod) {
                    return $method;
                }
            }
        }

        return null;
    }
}
