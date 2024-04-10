<?php


namespace InworkNet\SDK\Model\Request\Refund;


use InworkNet\SDK\Model\Request\AbstractRequestTransport;

class CreateRefundTransport extends AbstractRequestTransport
{
    const PATH = 'refund/create';

    /**
     * @inheritDoc
     */
    public function getPath()
    {
        return self::PATH;
    }
}
