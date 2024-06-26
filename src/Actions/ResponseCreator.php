<?php


namespace InworkNet\SDK\Actions;


use InworkNet\SDK\Exception\Response\ResponseParseException;
use InworkNet\SDK\Exception\Response\UnknownResponseTypeException;
use InworkNet\SDK\Exception\Response\UnsupportedResponseTypeException;
use InworkNet\SDK\Model\Response\AbstractResponse;

class ResponseCreator
{
    /**
     * @param string $response
     * @param array  $data
     *
     * @return AbstractResponse
     *
     * @throws UnknownResponseTypeException
     * @throws UnsupportedResponseTypeException
     * @throws ResponseParseException
     */
    public static function create($response, array $data)
    {
        if (!class_exists($response)) {
            throw new UnknownResponseTypeException(sprintf('Unknown response type: %s', $response));
        }

        $response = new $response();

        if (!$response instanceof AbstractResponse) {
            throw new UnsupportedResponseTypeException(sprintf('Unsupported response type: %s', get_class($response)));
        }

        try {
            $response->restore($data, array_merge($response->getRequiredFields(), $response->getOptionalFields()));
        } catch (\Exception $e) {
            throw new ResponseParseException($e->getMessage(), $e->getCode());
        }

        return $response;
    }
}
