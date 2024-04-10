<?php

namespace InworkNet\SDK\Model\Response\Payment;

use InworkNet\SDK\Model\Response\AbstractResponse;
use InworkNet\SDK\Model\Response\Item\OrderResponseItem;
use InworkNet\SDK\Model\Response\Item\ProjectResponseItem;
use InworkNet\SDK\Model\Response\Item\WalletResponseItem;
use InworkNet\SDK\Model\Traits\RecursiveRestoreTrait;

class CreatePaymentResponse extends AbstractResponse
{
    use RecursiveRestoreTrait;
    use GetPaymentResponseTrait;

    /**
     * @var string
     */
    private $paymentUrl;

    /**
     * @return string
     */
    public function getPaymentUrl()
    {
        return $this->paymentUrl;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields()
    {
        return [
            'id' => AbstractResponse::TYPE_INTEGER,
            'order' => OrderResponseItem::class,
            'token' => AbstractResponse::TYPE_STRING,
            'status' => AbstractResponse::TYPE_STRING,
            'payment_url' => AbstractResponse::TYPE_STRING,
            'create_date' => AbstractResponse::TYPE_DATE,
            'wallet' => WalletResponseItem::class,
            'project' => ProjectResponseItem::class,
        ];
    }
}
