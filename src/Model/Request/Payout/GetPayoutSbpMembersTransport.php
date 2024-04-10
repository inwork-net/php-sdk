<?php

namespace InworkNet\SDK\Model\Request\Payout;

use InworkNet\SDK\Model\Request\AbstractRequestTransport;

class GetPayoutSbpMembersTransport extends AbstractRequestTransport
{
    const PATH = 'payout/sbp-members';

    /**
     * @inheritDoc
     */
    public function getPath()
    {
        return self::PATH;
    }
}
