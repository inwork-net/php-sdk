<?php

namespace InworkNet\SDK\Model\Request\Payment;

use InworkNet\SDK\Model\Request\AbstractRequestSerializer;

class ApplePayVerifySerializer extends AbstractRequestSerializer
{
    /**
     * @inheritDoc
     */
    public function getSerializedData()
    {
        /** @var ApplePayVerifyRequest $applePayVerifyRequest */
        $applePayVerifyRequest = $this->request;

        return [
            'token' => $applePayVerifyRequest->getToken(),
            'host' => $applePayVerifyRequest->getHost(),
            'validation_url' => $applePayVerifyRequest->getValidationUrl(),
        ];
    }
}
