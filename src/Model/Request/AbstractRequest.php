<?php

namespace InworkNet\SDK\Model\Request;


use InworkNet\SDK\Model\Interfaces\RestorableInterface;

abstract class AbstractRequest implements RestorableInterface
{
    /**
     * @inheritDoc
     */
    public function getThoughOneField()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return var_export($this, true);
    }
}
