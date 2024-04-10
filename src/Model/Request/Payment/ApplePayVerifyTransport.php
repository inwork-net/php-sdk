<?php

namespace InworkNet\SDK\Model\Request\Payment;

use InworkNet\SDK\Model\Request\AbstractRequestTransport;

class ApplePayVerifyTransport extends AbstractRequestTransport
{
    const PATH = 'payment/apple/verify';

    /**
     * @inheritDoc
     */
    public function getPath()
    {
        return self::PATH;
    }
}
