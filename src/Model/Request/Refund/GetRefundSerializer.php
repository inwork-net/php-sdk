<?php


namespace InworkNet\SDK\Model\Request\Refund;


use InworkNet\SDK\Model\Request\AbstractRequestSerializer;

class GetRefundSerializer extends AbstractRequestSerializer
{
    /**
     * @inheritDoc
     */
    public function getSerializedData()
    {
        /** @var GetRefundRequest $request */
        $request = $this->request;

        return [
            'token' => $request->getToken(),
        ];
    }
}
