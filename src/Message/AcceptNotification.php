<?php

namespace Omnipay\Maksekeskus\Message;

use Maksekeskus\Maksekeskus;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Common\Message\ResponseInterface;

class AcceptNotification extends AbstractRequest implements NotificationInterface
{

    protected $data;

    public function initialize(array $parameters = array())
    {
        parent::initialize($parameters);

        $this->data = [
            'json' => $this->httpRequest->get('json'),
            'mac' => $this->httpRequest->get('mac'),
        ];

        $client = new Maksekeskus($this->getShopId(), $this->getKeyPublishable(), $this->getKeySecret(), $this->getTestMode());

        if (!$client->verifyMac($this->data)) {
            throw new InvalidRequestException('invalid signature');
        }

        $this->response = $client->extractRequestData($this->data, false);
    }

    /**
     * Get the raw data array for this message.
     * The raw data is from the JSON payload.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * There is nothing to send in order to response to this webhook.
     * The merchant site just needs to return a HTTP 200.
     *
     * @param  mixed $data The data to send
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTransactionReference()
    {
        return $this->response['transaction'];
    }

    /**
     * {@inheritdoc}
     */
    public function getTransactionStatus()
    {
        return match ($this->getCode()) {
            'CREATED', 'APPROVED', 'PENDING' => NotificationInterface::STATUS_PENDING,
            'COMPLETED' => NotificationInterface::STATUS_COMPLETED,
            'CANCELLED', 'EXPIRED' => NotificationInterface::STATUS_FAILED,
            'PART_REFUNDED', 'REFUNDED' => NotificationInterface::STATUS_FAILED,
            default => NotificationInterface::STATUS_FAILED,
        };
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getCode()
    {
        return $this->response['status'];
    }

}
