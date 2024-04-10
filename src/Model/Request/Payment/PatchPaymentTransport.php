<?php


namespace InworkNet\SDK\Model\Request\Payment;


use InworkNet\SDK\Model\Request\AbstractRequestTransport;
use InworkNet\SDK\Transport\AbstractApiTransport;

class PatchPaymentTransport extends AbstractRequestTransport
{
    const PATH = 'payment/patch';

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
