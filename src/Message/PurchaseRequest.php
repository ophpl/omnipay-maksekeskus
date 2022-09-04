<?php

namespace Omnipay\Maksekeskus\Message;

use Maksekeskus\Maksekeskus;
use Omnipay\Common\Exception\InvalidRequestException;

class PurchaseRequest extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    public function getData()
    {
        $this->validate(
            'amount',
            'currency',
            'transactionId',
            'description',
            'returnUrl',
            'cancelUrl',
            'notifyUrl',
            'clientIp'
        );

        $data = array(
            "transaction" => array(
                "amount" => $this->getAmount(),
                "currency" => $this->getCurrency(),
                "reference" => $this->getTransactionId(),
                "merchant_data" =>  $this->getDescription(),
                "transaction_url" => array(
                    "return_url" => array(
                        "url" => $this->getReturnUrl(),
                        "method" => "POST"
                    ),
                    "cancel_url" => array(
                        "url" => $this->getCancelUrl(),
                        "method" => "POST"
                    ),
                    "notification_url" => array(
                        "url" => $this->getNotifyUrl(),
                        "method" => "POST"
                    )
                )
            ),
            "customer" => array(
                "ip" => $this->getClientIp(),
                "locale" => $this->getLanguage(),
            ),
        );

        // Setup optional client data
        if ($card = $this->getCard()) {
            $data['customer']['email'] = $card->getEmail();
            $data['customer']['country'] = $card->getBillingCountry();
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        try {
            $client = new Maksekeskus($this->getShopId(), $this->getKeyPublishable(), $this->getKeySecret(), $this->getTestMode());
            $response = $client->createTransaction($data);
            return $this->response = new PurchaseResponse($this, $response);
        } catch (\Throwable $e) {
            throw new InvalidRequestException('Failed to request purchase: ' . $e->getMessage(), 0, $e);
        }
    }
}
