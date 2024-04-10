<?php

namespace InworkNet\SDK\Model\Response\Payment;

use InworkNet\SDK\Model\Response\AbstractResponse;
use InworkNet\SDK\Model\Response\Item\AuthorizationItem;
use InworkNet\SDK\Model\Response\Item\ErrorDetailsItem;
use InworkNet\SDK\Model\Response\Item\MoneyItem;
use InworkNet\SDK\Model\Response\Item\OrderResponseItem;
use InworkNet\SDK\Model\Response\Item\PaymentMethodItem;
use InworkNet\SDK\Model\Response\Item\ProjectResponseItem;
use InworkNet\SDK\Model\Response\Item\WalletResponseItem;
use InworkNet\SDK\Model\Traits\RecursiveRestoreTrait;

class ProcessPaymentResponse extends AbstractResponse
{
    use RecursiveRestoreTrait;
    use GetPaymentResponseTrait;

    /**
     * @var AuthorizationItem|null
     */
    private $authorization;

    /**
     * @return AuthorizationItem|null
     */
    public function getAuthorization()
    {
        return $this->authorization;
    }

    /**
     * @param AuthorizationItem|null $authorization
     *
     * @return $this
     */
    public function setAuthorization($authorization)
    {
        $this->authorization = $authorization;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields()
    {
        return [
            'id' => self::TYPE_INTEGER,
            'order' => OrderResponseItem::class,
            'wallet' => WalletResponseItem::class,
            'project' => ProjectResponseItem::class,
            'token' => self::TYPE_STRING,
            'create_date' => self::TYPE_DATE,
            'ip' => self::TYPE_STRING,
            'status' => self::TYPE_STRING,
            'payment_method' => PaymentMethodItem::class,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields()
    {
        return [
            'partner_payment_id' => self::TYPE_STRING,
            'expire_date' => self::TYPE_DATE,
            'status_description' => self::TYPE_STRING,
            'custom_parameters' => self::TYPE_ARRAY,
            'update_date' => self::TYPE_DATE,
            'is_test' => self::TYPE_BOOLEAN,
            'authorization' => AuthorizationItem::class,
            'available_full_refund' => self::TYPE_BOOLEAN,
            'available_partial_refund' => self::TYPE_BOOLEAN,
            'available_for_refund' => MoneyItem::class,
            'payer' => MoneyItem::class,
            'extra' => MoneyItem::class,
            'error_details' => ErrorDetailsItem::class,
        ];
    }
}
