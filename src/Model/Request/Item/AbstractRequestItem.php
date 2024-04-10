<?php

namespace InworkNet\SDK\Model\Request\Item;


use InworkNet\SDK\Model\Interfaces\RestorableInterface;

abstract class AbstractRequestItem implements RestorableInterface
{
    /**
     * @inheritDoc
     */
    public function getThoughOneField()
    {
        return [];
    }
}
