<?php


namespace InworkNet\SDK\Model\Request\Payout;


use InworkNet\SDK\Model\Request\AbstractRequest;
use InworkNet\SDK\Model\Traits\RecursiveRestoreTrait;

class GetPayoutRequestById extends AbstractRequest
{
    use RecursiveRestoreTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * GetPayoutRequestById constructor.
     *
     * @param int $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields()
    {
        return [
            'id' => self::TYPE_INTEGER,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields()
    {
        return [];
    }
}
