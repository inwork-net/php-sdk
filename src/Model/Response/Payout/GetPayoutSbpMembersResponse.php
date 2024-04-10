<?php

namespace InworkNet\SDK\Model\Response\Payout;

use InworkNet\SDK\Model\Response\AbstractResponse;
use InworkNet\SDK\Model\Response\Item\SbpMemberItem;
use InworkNet\SDK\Model\Traits\RecursiveRestoreTrait;

class GetPayoutSbpMembersResponse extends AbstractResponse
{
    use RecursiveRestoreTrait;

    /**
     * @var SbpMemberItem[]
     */
    private $members;

    public function getRequiredFields()
    {
        return [
            'members' => [SbpMemberItem::class],
        ];
    }

    public function getOptionalFields()
    {
        return [];
    }
}
