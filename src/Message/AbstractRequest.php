<?php

namespace Omnipay\Maksekeskus\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
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
     * Get locale.
     *
     * @return string locale
     */
    public function getLocale()
    {
        return $this->getParameter('locale');
    }

    /**
     * Set locale.
     *
     * @param string $value locale
     *
     * @return $this
     */
    public function setLocale($value)
    {
        return $this->setParameter('locale', $value);
    }

    /**
     * Get language, if not set fallback to locale.
     *
     * @return string language
     */
    public function getLanguage()
    {
        $language = $this->getParameter('language');

        if (empty($language)) {
            $locale = $this->getLocale();

            if (empty($locale)) {
                return "";
            }

            // convert to IETF locale tag if other style is provided and then get first part, primary language
            $language = strtok(str_replace('_', '-', $locale), '-');
        }

        return strtolower($language);
    }

    /**
     * Set language.
     *
     * @param string $value language
     *
     * @return $this
     */
    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }
}
