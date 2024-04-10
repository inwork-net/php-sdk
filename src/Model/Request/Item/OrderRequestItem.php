<?php


namespace InworkNet\SDK\Model\Request\Item;


use InworkNet\SDK\Model\Traits\OrderItemTrait;
use InworkNet\SDK\Model\Traits\RecursiveRestoreTrait;

class OrderRequestItem extends AbstractRequestItem
{
    use OrderItemTrait;
    use RecursiveRestoreTrait;

    /**
     * @inheritDoc
     */
    public function getRequiredFields()
    {
        return [
            'currency' => self::TYPE_STRING,
            'amount' => self::TYPE_FLOAT,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields()
    {
        return [
            'description' => self::TYPE_STRING,
        ];
    }
}
