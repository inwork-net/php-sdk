<?php


namespace InworkNet\SDK\Model\Request\Wallet;


use InworkNet\SDK\Model\Request\AbstractRequestTransport;
use InworkNet\SDK\Transport\AbstractApiTransport;

class WalletTransport extends AbstractRequestTransport
{
    const PATH = 'wallet/get';

    public function getPath()
    {
        return self::PATH;
    }

    public function getMethod()
    {
        return AbstractApiTransport::METHOD_POST;
    }
}
