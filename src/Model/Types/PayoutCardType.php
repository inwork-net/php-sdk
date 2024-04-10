<?php


namespace InworkNet\SDK\Model\Types;


use InworkNet\SDK\Exception\Validation\InvalidPropertyException;
use InworkNet\SDK\Model\Interfaces\RestorableInterface;
use InworkNet\SDK\Model\PaymentMethods;
use InworkNet\SDK\Model\PayoutCardTypes;
use InworkNet\SDK\Model\Response\Item\PayoutMethodItem;

class PayoutCardType extends AbstractCustomType
{
    /**
     * @inheritDoc
     */
    public function validate($field)
    {
        $value = $this->getValue($field);

        if ($this->object->getMethod() === PaymentMethods::PAYMENT_METHOD_CARD
            && !in_array($value, PayoutCardTypes::getAvailableCardTypes(), true)) {
            throw new InvalidPropertyException('Unsupportable card type', 0, $field);
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function isAccept()
    {
        return $this->object instanceof PayoutMethodItem;
    }

    /**
     * @inheritDoc
     */
    public function getBaseType()
    {
        return RestorableInterface::TYPE_STRING;
    }
}
