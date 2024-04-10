<?php


namespace InworkNet\SDK\Model\Request\Refund;


use InworkNet\SDK\Model\Request\AbstractRequestTransport;

class GetRefundTransport extends AbstractRequestTransport
{
    const PATH = 'refund/get';

    /**
     * @inheritDoc
     */
    public function getPath()
    {
        return self::PATH;
    }
}
