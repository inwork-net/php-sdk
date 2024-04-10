<?php


namespace InworkNet\SDK\Model\Request\Payout;


use InworkNet\SDK\Model\Request\AbstractRequestTransport;
use InworkNet\SDK\Transport\AbstractApiTransport;

class GetPayoutTransport extends AbstractRequestTransport
{
    const PATH = 'payout/get';

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
