<?php


namespace InworkNet\SDK\Model\Request\Subscription;


use InworkNet\SDK\Model\Request\AbstractRequestTransport;

class GetSubscriptionTransport extends AbstractRequestTransport
{
    const PATH = 'subscription/get';

    public function getPath()
    {
        return self::PATH;
    }
}
