<?php


namespace InworkNet\SDK\Model\Types;


use InworkNet\SDK\Exception\Validation\InvalidPropertyException;
use InworkNet\SDK\Model\Interfaces\RestorableInterface;
use InworkNet\SDK\Transport\AbstractApiTransport;

class HttpMethodType extends AbstractCustomType
{
    /**
     * @inheritDoc
     */
    public function validate($field)
    {
        $httpMethod = $this->getValue($field);

        if (!in_array($httpMethod, [AbstractApiTransport::METHOD_POST, AbstractApiTransport::METHOD_GET], true)) {
            throw new InvalidPropertyException('Unsupportable http method. There are available only POST and GET methods', 0, $field);
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
