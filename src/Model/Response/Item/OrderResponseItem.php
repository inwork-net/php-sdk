<?php


namespace InworkNet\SDK\Model\Response\Item;


use InworkNet\SDK\Model\Interfaces\RestorableInterface;
use InworkNet\SDK\Model\Response\AbstractResponse;
use InworkNet\SDK\Model\Traits\OrderItemTrait;
use InworkNet\SDK\Model\Traits\RecursiveRestoreTrait;

class OrderResponseItem extends AbstractResponse
{
    use OrderItemTrait;
    use RecursiveRestoreTrait;

    /**
     * @inheritDoc
     */
    public function getOptionalFields()
    {
        return [
            'description' => RestorableInterface::TYPE_STRING,
        ];
    }

    public function getRequiredFields()
    {
        return [
            'currency' => RestorableInterface::TYPE_STRING,
            'amount' => RestorableInterface::TYPE_FLOAT,
        ];
    }
}
