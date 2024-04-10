<?php


namespace InworkNet\SDK\Model\Types;


use InworkNet\SDK\Exception\Validation\InvalidPropertyException;
use InworkNet\SDK\Model\Interfaces\RestorableInterface;
use InworkNet\SDK\Model\Request\Item\ItemsReceiptRequestItem;

class TaxType extends AbstractCustomType
{
    /**
     * @inheritDoc
     */
    public function validate($field)
    {
        $tax = $this->getValue($field);


        if (!in_array($tax, ItemsReceiptRequestItem::getAvailableTaxes(), true)) {
            throw new InvalidPropertyException('Unsupportable tax type', 0, $field);
        }

        return;
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
