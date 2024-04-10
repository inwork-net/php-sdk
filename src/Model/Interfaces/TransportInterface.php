<?php


namespace InworkNet\SDK\Model\Interfaces;


use InworkNet\SDK\Model\Request\AbstractRequestSerializer;
use InworkNet\SDK\Model\Request\AbstractRequestTransport;

interface TransportInterface
{
    /**
     * @param AbstractRequestSerializer $serializer
     *
     * @return AbstractRequestTransport
     */
    public function getTransport(AbstractRequestSerializer $serializer);
}
