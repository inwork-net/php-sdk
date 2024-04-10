<?php


namespace InworkNet\SDK\Model\Request\Wallet;


use InworkNet\SDK\Model\Request\AbstractRequestSerializer;

class WalletSerializer extends AbstractRequestSerializer
{
    public function getSerializedData()
    {
        /** @var WalletRequest $walletRequest */
        $walletRequest = $this->request;

        return [
            'id' => $walletRequest->getId(),
        ];
    }
}
