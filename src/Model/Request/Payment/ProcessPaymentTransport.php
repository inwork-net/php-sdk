<?php


namespace InworkNet\SDK\Model\Request\Payment;


use InworkNet\SDK\Model\Request\AbstractRequestTransport;
use InworkNet\SDK\Transport\AbstractApiTransport;

class ProcessPaymentTransport extends AbstractRequestTransport
{
    const PATH = 'payment/process';
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
