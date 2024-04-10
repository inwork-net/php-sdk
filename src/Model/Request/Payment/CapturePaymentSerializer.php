<?php


namespace InworkNet\SDK\Model\Request\Payment;


use InworkNet\SDK\Model\Request\AbstractRequestSerializer;

class CapturePaymentSerializer extends AbstractRequestSerializer
{
    /**
     * @inheritDoc
     */
    public function getSerializedData()
    {
        /** @var CapturePaymentRequest $paymentRequest */
        $paymentRequest = $this->request;

        return [
            'token' => $paymentRequest->getToken(),
        ];
    }
}
