<?php

namespace Omnipay\Maksekeskus\Message;

use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->getCode() == 'COMPLETED';
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return in_array($this->getCode(), ['CREATED', 'APPROVED', 'PENDING']);
    }

    /**
     * @return bool
     */
    public function isCancelled()
    {
        return in_array($this->getCode(), ['CANCELLED', 'EXPIRED', 'PART_REFUNDED', 'REFUNDED']);
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->data['transaction'] ?? null;
    }

    /**
     * @return string
     */
    public function getTransactionReference()
    {
        return $this->data['reference'] ?? null;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->data['status'] ?? null;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return '';
    }

}
