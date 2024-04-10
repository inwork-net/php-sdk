<?php


namespace InworkNet\SDK\Model\Types;


use InworkNet\SDK\Exception\Validation\InvalidPropertyException;
use InworkNet\SDK\Model\Interfaces\RestorableInterface;
use InworkNet\SDK\Model\Request\Item\FeeItem;

class FeeType extends AbstractCustomType
{
    /**
     * @inheritDoc
     */
    public function validate($field)
    {
        $value = $this->getValue($field);

        if (!in_array($value, [FeeItem::TYPE_PAYOUT, FeeItem::TYPE_WALLET], true)) {
            throw new InvalidPropertyException('Unsupportable payment type', 0, $field);
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function isAccept()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getBaseType()
    {
        return RestorableInterface::TYPE_STRING;
    }
}
