<?php

namespace InworkNet\SDK;

use InworkNet\SDK\Actions\RequestCreator;
use InworkNet\SDK\Exception\Notification\EmptyApiKeyException;
use InworkNet\SDK\Exception\Notification\IncorrectBodyRequestException;
use InworkNet\SDK\Exception\Notification\NotificationParseException;
use InworkNet\SDK\Exception\Notification\NotificationSecurityException;
use InworkNet\SDK\Model\Request\NotificationRequest;

class Notification
{
    const RESPONSE_SUCCESS = 'ok';

    const RESPONSE_ERROR = 'error';

    private $skipIpCheck = false;

    private $allowedIps = [
        // IPv4
        '95.216.144.80',
        '95.216.143.141',
        '52.213.148.150',
        // Cloudflare: https://developers.cloudflare.com/support/network/understanding-and-configuring-cloudflares-ipv6-support/
        '248.146.203.102',
        '255.157.240.143',
        '243.82.72.14',
        // IPv6
        '2a05:d018:a64:9561:b655:cabb:4a9a:23b6',
        '2a01:4f9:c010:850::1',
        '2a01:4f9:c010:78e::1',
    ];

    private $apiKey;

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return string[]
     */
    public function getAllowedIps()
    {
        return $this->allowedIps;
    }

    /**
     * @param string[] $allowedIps
     */
    public function setAllowedIps($allowedIps)
    {
        $this->allowedIps = $allowedIps;
    }

    /**
     * @param string $allowedIp
     *
     * @return void
     */
    public function addAllowedIp($allowedIp)
    {
        $this->allowedIps[] = $allowedIp;
    }

    /**
     * @param bool $autoResponse
     *
     * @return NotificationRequest
     *
     * @throws EmptyApiKeyException
     * @throws NotificationSecurityException
     * @throws NotificationParseException
     * @throws IncorrectBodyRequestException
     * @throws \Exception
     */
    public function process($autoResponse = true)
    {
        try {
            $request = $this->getRequest();
            $autoResponse && $this->successResponse();
        } catch (\Exception $e) {
            $autoResponse && $this->errorResponse($e->getMessage());

            throw $e;
        }

        return $request;
    }

    public function successResponse()
    {
        $this->response(self::RESPONSE_SUCCESS);
    }

    public function errorResponse($message)
    {
        $this->response(self::RESPONSE_ERROR, $message);
    }

    public function setSkipIpCheck($skip = true)
    {
        $this->skipIpCheck = $skip;
    }

    public function isIpCheckSkipped()
    {
        return $this->skipIpCheck;
    }

    /**
     * @return NotificationRequest
     *
     * @throws NotificationSecurityException
     * @throws NotificationParseException
     * @throws IncorrectBodyRequestException
     * @throws EmptyApiKeyException
     */
    protected function getRequest()
    {
        if (empty($this->apiKey)) {
            throw new EmptyApiKeyException('Please provide the api key');
        }

        $this->checkRequest();

        return $this->getRequestFromBody();
    }

    protected function response($status, $message = null)
    {
        $response = [
            'status' => $status,
        ];

        if ($message) {
            $response['message'] = $message;
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     * @return NotificationRequest
     *
     * @throws NotificationParseException
     * @throws IncorrectBodyRequestException
     */
    protected function getRequestFromBody()
    {
        $body = $this->getBody();

        if (!is_string($body)) {
            throw new IncorrectBodyRequestException('The request body contains an invalid json');
        }

        $body = json_decode($body, true);

        if ($body === null) {
            throw new IncorrectBodyRequestException('The request body contains an invalid json');
        }

        try {
            /** @var NotificationRequest $request */
            $request = RequestCreator::create(NotificationRequest::class, $body);
        } catch (\Exception $e) {
            throw new NotificationParseException('An error occurred while parsing the request');
        }

        return $request;
    }

    /**
     * @throws NotificationSecurityException
     */
    protected function checkRequest()
    {
        if (!empty($_SERVER['HTTP_X_API_SIGNATURE'])) {
            $signature = $_SERVER['HTTP_X_API_SIGNATURE'];
        } else {
            throw new NotificationSecurityException('Empty signature');
        }

        $signature = strtolower($signature);
        $expectedSignature = strtolower(hash('sha256', $this->getBody() . $this->apiKey));

        if ($signature !== $expectedSignature) {
            throw new NotificationSecurityException('Incorrect signature');
        }

        if (strtolower($_SERVER['REQUEST_METHOD']) !== 'post') {
            throw new NotificationSecurityException('Only post requests are expected');
        }

        if (!$this->isIpAllowed()) {
            throw new NotificationSecurityException('Remote ip is not allowed');
        }
    }

    /**
     * @return bool|string
     */
    protected function getBody()
    {
        return file_get_contents('php://input');
    }

    /**
     * @return bool
     */
    protected function isIpAllowed()
    {
        return $this->skipIpCheck || in_array($_SERVER['REMOTE_ADDR'], $this->allowedIps);
    }
}
