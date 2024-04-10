<?php


namespace InworkNet\SDK\Model\Request\Payment;


use InworkNet\SDK\Model\Request\AbstractRequestTransport;
use InworkNet\SDK\Transport\AbstractApiTransport;

class CapturePaymentTransport extends AbstractRequestTransport
{
    const PATH = 'payment/capture';

    /**
     * @inheritDoc
     */
    public function getPath()
    {
        return self::PATH;
    }

    /**
     * @inheritDoc
     */
    public function getMethod()
    {
        return AbstractApiTransport::METHOD_POST;
    }
}
