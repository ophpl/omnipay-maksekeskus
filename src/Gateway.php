<?php

namespace Omnipay\Maksekeskus;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Maksekeskus\Message\PurchaseRequest;

/**
 * Class Gateway
 * https://developer.maksekeskus.ee/
 * https://github.com/maksekeskus/maksekeskus-php
 * @package Omnipay\Maksekeskus
 */
class Gateway extends AbstractGateway
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Maksekeskus';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'shopId' => '',
            'keyPublishable' => '',
            'keySecret' => '',
            'paymentMethod' => 'redirect',
            'testMode' => false
        );
    }

    /**
     * Get shop id.
     *
     * @return string shop id
     */
    public function getShopId()
    {
        return $this->getParameter('shopId');
    }

    /**
     * Set shop id.
     *
     * @param string $value shop id
     *
     * @return $this
     */
    public function setShopId($value)
    {
        return $this->setParameter('shopId', $value);
    }

    /**
     * Get key publishable.
     *
     * @return string key publishable
     */
    public function getKeyPublishable()
    {
        return $this->getParameter('keyPublishable');
    }

    /**
     * Set key publishable.
     *
     * @param string $value key publishable
     *
     * @return $this
     */
    public function setKeyPublishable($value)
    {
        return $this->setParameter('keyPublishable', $value);
    }

    /**
     * Get key secret.
     *
     * @return string key secret
     */
    public function getKeySecret()
    {
        return $this->getParameter('keySecret');
    }

    /**
     * Set key secret.
     *
     * @param string $value key secret
     *
     * @return $this
     */
    public function setKeySecret($value)
    {
        return $this->setParameter('keySecret', $value);
    }

    /**
     * Get payment method.
     *
     * @return string payment method
     */
    public function getPaymentMethod()
    {
        return $this->getParameter('paymentMethod');
    }

    /**
     * Set payment method.
     *
     * @param string $value payment method
     *
     * @return $this
     */
    public function setPaymentMethod($value)
    {
        return $this->setParameter('paymentMethod', $value);
    }

    /**
     * @param array $parameters
     *
     * @return AbstractRequest|PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Maksekeskus\Message\PurchaseRequest', $parameters);
    }
}
