<?php


namespace InworkNet\SDK\Model\Response\Payment;


use InworkNet\SDK\Model\Response\AbstractResponse;
use InworkNet\SDK\Model\Traits\RecursiveRestoreTrait;

class GetPaymentResponse extends AbstractResponse
{
    use RecursiveRestoreTrait;
    use GetPaymentResponseTrait;
}
