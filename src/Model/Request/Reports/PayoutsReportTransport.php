<?php

namespace InworkNet\SDK\Model\Request\Reports;

use InworkNet\SDK\Model\Request\AbstractRequestTransport;
use InworkNet\SDK\Transport\AbstractApiTransport;

class PayoutsReportTransport extends AbstractRequestTransport
{
    const PATH = 'report/payouts/registry.csv';

    /**
     * @inheritDoc
     */
    public function getPath()
    {
        return self::PATH;
    }

    /**
     * @inheritDoc
     */
    public function getMethod()
    {
        return AbstractApiTransport::METHOD_GET;
    }

    public function getBodyForRequest()
    {
        return $this->getBody();
    }
}
