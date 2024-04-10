<?php

namespace InworkNet\SDK\Model\Response;


use InworkNet\SDK\Model\Interfaces\RestorableInterface;

abstract class AbstractResponse implements RestorableInterface
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
