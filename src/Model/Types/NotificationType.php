<?php


namespace InworkNet\SDK\Model\Types;


use InworkNet\SDK\Exception\Validation\InvalidPropertyException;
use InworkNet\SDK\Model\NotificationTypes;
use InworkNet\SDK\Model\Request\AbstractRequest;

class NotificationType extends AbstractCustomType
{
    public function validate($field)
    {
        $notificationType = $this->getValue($field);

        if (!in_array($notificationType, NotificationTypes::getAvailableTypes(), true)) {
            throw new InvalidPropertyException('Unsupportable payment status', 0, $field);
        }

        return true;
    }

    public function isAccept()
    {
        return true;
    }

    public function getBaseType()
    {
        return AbstractRequest::TYPE_STRING;
    }
}
