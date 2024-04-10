<?php


namespace InworkNet\SDK\Transport\Authorization;


interface AuthorizationInterface
{
    /**
     * @return string
     */
    public function getAuthorizationHeader();
}
