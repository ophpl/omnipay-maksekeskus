<?php

namespace Omnipay\Maksekeskus\Message;

use Maksekeskus\Maksekeskus;
use Omnipay\Common\Exception\InvalidRequestException;

class CompletePurchaseRequest extends AbstractRequest
{
    /**
     * @return array
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $request = [
            'json' => $this->httpRequest->get('json'),
            'mac' => $this->httpRequest->get('mac'),
        ];

        $client = new Maksekeskus($this->getShopId(), $this->getKeyPublishable(), $this->getKeySecret(), $this->getTestMode());

        if ($client->verifyMac($request)) {
            $data = $client->extractRequestData($request, false);
        }

        return $data;
    }

    /**
     * @param array $data
     *
     * @return CompletePurchaseResponse
     */
    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}
