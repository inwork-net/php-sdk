<?php

namespace InworkNet\SDK\Model\Types;

use InworkNet\SDK\Exception\Validation\InvalidPropertyException;
use InworkNet\SDK\Model\Request\AbstractRequest;
use InworkNet\SDK\Model\Request\Item\PaymentMethodDataItem;

class PaymentMethodTokenType extends AbstractCustomType
{
    /**
     * @inheritDoc
     */
    public function validate($field)
    {
        $tokenMode = $this->getValue($field);

        if (empty($tokenMode)) {
            return true;
        }

        $availablePaymentMethods = [
            PaymentMethodDataItem::TOKEN_TYPE_APPLE_PAY,
            PaymentMethodDataItem::TOKEN_TYPE_GOOGLE_PAY,
        ];

        if (!in_array($tokenMode, $availablePaymentMethods, true)) {
            throw new InvalidPropertyException('Unsupportable token type', 0, $field);
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
        return AbstractRequest::TYPE_STRING;
    }
}
