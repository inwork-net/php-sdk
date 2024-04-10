<?php


namespace InworkNet\SDK\Model\Response\Item;


use InworkNet\SDK\Model\Response\AbstractResponse;
use InworkNet\SDK\Model\Response\Payment\GetPaymentResponseTrait;
use InworkNet\SDK\Model\Traits\RecursiveRestoreTrait;

class PaymentItem extends AbstractResponse
{
    use RecursiveRestoreTrait;
    use GetPaymentResponseTrait;
}
