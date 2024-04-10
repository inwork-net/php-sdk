<?php

namespace InworkNet\SDK\Model\Request\Payout;

use InworkNet\SDK\Model\Request\AbstractRequest;
use InworkNet\SDK\Model\Traits\RecursiveRestoreTrait;

class GetPayoutSbpMembersRequest extends AbstractRequest
{
    use RecursiveRestoreTrait;

    public function getRequiredFields()
    {
        return [];
    }

    public function getOptionalFields()
    {
        return [];
    }
}
