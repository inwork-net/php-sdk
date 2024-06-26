<?php


namespace InworkNet\SDK\Exception\Validation;

use InworkNet\SDK\Exception\Validation\Traits\PropertyExceptionTrait;


class BadGetterException extends \BadMethodCallException
{
    use PropertyExceptionTrait;

    /**
     * @inheritDoc
     */
    public function __construct($message = '', $code = 0, $property = '', $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->property = $property;
    }
}
