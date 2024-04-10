<?php


namespace InworkNet\SDK\Model\Request\Subscription;


use InworkNet\SDK\Model\Request\AbstractRequestSerializer;

class GetSubscriptionSerializer extends AbstractRequestSerializer
{
    public function getSerializedData()
    {
        /** @var GetSubscriptionRequest $request */
        $request = $this->request;

        return [
            'token' => $request->getToken(),
        ];
    }
}
