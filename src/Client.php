<?php


namespace InworkNet\SDK;


use GuzzleHttp\Psr7;
use InworkNet\SDK\Actions\ObjectRecursiveValidator;
use InworkNet\SDK\Actions\RequestCreator;
use InworkNet\SDK\Actions\ResponseCreator;
use InworkNet\SDK\Exception\ClientIncorrectAuthTypeException;
use InworkNet\SDK\Exception\JsonParseException;
use InworkNet\SDK\Exception\Request\RequestParseException;
use InworkNet\SDK\Exception\Response\ResponseParseException;
use InworkNet\SDK\Exception\ServerResponse\BadRequestException;
use InworkNet\SDK\Exception\ServerResponse\ForbiddenException;
use InworkNet\SDK\Exception\ServerResponse\InternalServerException;
use InworkNet\SDK\Exception\ServerResponse\NotFoundException;
use InworkNet\SDK\Exception\ServerResponse\RequestTimeoutException;
use InworkNet\SDK\Exception\ServerResponse\ResponseException;
use InworkNet\SDK\Exception\ServerResponse\TooManyRequestsException;
use InworkNet\SDK\Exception\ServerResponse\UnauthorizedException;
use InworkNet\SDK\Exception\TransportException;
use InworkNet\SDK\Model\Request\AbstractRequest;
use InworkNet\SDK\Model\Request\AbstractRequestTransport;
use InworkNet\SDK\Model\Request\Payment\ApplePayVerifyRequest;
use InworkNet\SDK\Model\Request\Payment\ApplePayVerifySerializer;
use InworkNet\SDK\Model\Request\Payment\ApplePayVerifyTransport;
use InworkNet\SDK\Model\Request\Payment\CancelPaymentRequest;
use InworkNet\SDK\Model\Request\Payment\CancelPaymentSerializer;
use InworkNet\SDK\Model\Request\Payment\CancelPaymentTransport;
use InworkNet\SDK\Model\Request\Payment\CapturePaymentRequest;
use InworkNet\SDK\Model\Request\Payment\CapturePaymentSerializer;
use InworkNet\SDK\Model\Request\Payment\CapturePaymentTransport;
use InworkNet\SDK\Model\Request\Payment\CreatePaymentRequest;
use InworkNet\SDK\Model\Request\Payment\CreatePaymentSerializer;
use InworkNet\SDK\Model\Request\Payment\CreatePaymentTransport;
use InworkNet\SDK\Model\Request\Payment\GetPaymentRequest;
use InworkNet\SDK\Model\Request\Payment\GetPaymentSerializer;
use InworkNet\SDK\Model\Request\Payment\GetPaymentTransport;
use InworkNet\SDK\Model\Request\Payment\PatchPaymentRequest;
use InworkNet\SDK\Model\Request\Payment\PatchPaymentSerializer;
use InworkNet\SDK\Model\Request\Payment\PatchPaymentTransport;
use InworkNet\SDK\Model\Request\Payment\ProcessPaymentRequest;
use InworkNet\SDK\Model\Request\Payment\ProcessPaymentSerializer;
use InworkNet\SDK\Model\Request\Payment\ProcessPaymentTransport;
use InworkNet\SDK\Model\Request\Payout\CreatePayoutRequest;
use InworkNet\SDK\Model\Request\Payout\CreatePayoutSerializer;
use InworkNet\SDK\Model\Request\Payout\CreatePayoutTransport;
use InworkNet\SDK\Model\Request\Payout\GetPayoutRequest;
use InworkNet\SDK\Model\Request\Payout\GetPayoutRequestById;
use InworkNet\SDK\Model\Request\Payout\GetPayoutSbpMembersRequest;
use InworkNet\SDK\Model\Request\Payout\GetPayoutSbpMembersSerializer;
use InworkNet\SDK\Model\Request\Payout\GetPayoutSbpMembersTransport;
use InworkNet\SDK\Model\Request\Payout\GetPayoutSerializer;
use InworkNet\SDK\Model\Request\Payout\GetPayoutTransport;
use InworkNet\SDK\Model\Request\Refund\CreateRefundRequest;
use InworkNet\SDK\Model\Request\Refund\CreateRefundSerializer;
use InworkNet\SDK\Model\Request\Refund\CreateRefundTransport;
use InworkNet\SDK\Model\Request\Refund\GetRefundRequest;
use InworkNet\SDK\Model\Request\Refund\GetRefundSerializer;
use InworkNet\SDK\Model\Request\Refund\GetRefundTransport;
use InworkNet\SDK\Model\Request\Reports\PaymentsReportRequest;
use InworkNet\SDK\Model\Request\Reports\PaymentsReportSerializer;
use InworkNet\SDK\Model\Request\Reports\PaymentsReportTransport;
use InworkNet\SDK\Model\Request\Reports\PayoutsReportRequest;
use InworkNet\SDK\Model\Request\Reports\PayoutsReportSerializer;
use InworkNet\SDK\Model\Request\Reports\PayoutsReportTransport;
use InworkNet\SDK\Model\Request\Subscription\GetSubscriptionRequest;
use InworkNet\SDK\Model\Request\Subscription\GetSubscriptionSerializer;
use InworkNet\SDK\Model\Request\Subscription\GetSubscriptionTransport;
use InworkNet\SDK\Model\Request\Wallet\WalletRequest;
use InworkNet\SDK\Model\Request\Wallet\WalletSerializer;
use InworkNet\SDK\Model\Response\AbstractResponse;
use InworkNet\SDK\Model\Response\Payment\ApplePayVerifyResponse;
use InworkNet\SDK\Model\Response\Payment\CancelPaymentResponse;
use InworkNet\SDK\Model\Response\Payment\CapturePaymentResponse;
use InworkNet\SDK\Model\Response\Payment\CreatePaymentResponse;
use InworkNet\SDK\Model\Response\Payment\GetPaymentResponse;
use InworkNet\SDK\Model\Response\Payment\ProcessPaymentResponse;
use InworkNet\SDK\Model\Response\Payout\CreatePayoutResponse;
use InworkNet\SDK\Model\Response\Payout\GetPayoutResponse;
use InworkNet\SDK\Model\Response\Payout\GetPayoutSbpMembersResponse;
use InworkNet\SDK\Model\Response\Refund\CreateRefundResponse;
use InworkNet\SDK\Model\Response\Refund\GetRefundResponse;
use InworkNet\SDK\Model\Response\Subscription\GetSubscriptionResponse;
use InworkNet\SDK\Model\Response\Wallet\WalletResponse;
use InworkNet\SDK\Transport\AbstractApiTransport;
use InworkNet\SDK\Transport\Authorization\BasicAuthorization;
use InworkNet\SDK\Transport\Authorization\TokenAuthorization;
use InworkNet\SDK\Transport\CurlApiTransport;

class Client
{
    const VERSION = '1.0.1';

    /** @var AbstractApiTransport */
    private $apiTransport;

    public function __construct(AbstractApiTransport $apiTransport = null)
    {
        $this->apiTransport = $apiTransport;
        if (!$this->apiTransport) {
            $this->apiTransport = new CurlApiTransport();
        }
    }

    /**
     * @param string $login
     * @param string $secret
     * @param string $type
     *
     * @throws ClientIncorrectAuthTypeException
     */
    public function setAuth($login, $secret, $type = TokenAuthorization::class)
    {
        switch ($type) {
            case TokenAuthorization::class:
                $auth = new TokenAuthorization($login, $secret);
                break;
            case BasicAuthorization::class:
                $auth = new BasicAuthorization($login, $secret);
                break;
            default:
                throw new ClientIncorrectAuthTypeException('Unknown authorization type');
        }

        $this->apiTransport->setAuth($auth);
    }

    /**
     * @param CreatePaymentRequest|AbstractRequest|array $payment
     *
     * @return CreatePaymentResponse|AbstractResponse
     *
     * @throws TransportException
     * @throws JsonParseException
     * @throws ResponseException
     * @throws ResponseParseException
     * @throws RequestParseException
     */
    public function createPayment($payment)
    {
        if (is_array($payment)) {
            $payment = RequestCreator::create(CreatePaymentRequest::class, $payment);
        }

        ObjectRecursiveValidator::validate($payment);
        $paymentSerializer = new CreatePaymentSerializer($payment);
        $paymentTransport = new CreatePaymentTransport($paymentSerializer);

        return $this->execute($paymentTransport, CreatePaymentResponse::class);
    }

    /**
     * @param PatchPaymentRequest|AbstractRequest|array  $payment
     *
     * @return AbstractResponse
     * @throws ResponseException
     * @throws TransportException
     * @internal
     */
    public function patchPayment($payment)
    {
        if (is_array($payment)) {
            $payment = RequestCreator::create(PatchPaymentRequest::class, $payment);
        }

        ObjectRecursiveValidator::validate($payment);
        $paymentSerializer = new PatchPaymentSerializer($payment);
        $paymentTransport = new PatchPaymentTransport($paymentSerializer);

        return $this->execute($paymentTransport, GetPaymentResponse::class);
    }

    /**
     * @param ProcessPaymentRequest|AbstractRequest|array $payment
     *
     * @return ProcessPaymentResponse|AbstractResponse
     *
     * @throws TransportException
     * @throws JsonParseException
     * @throws ResponseException
     * @throws ResponseParseException
     * @throws RequestParseException
     */
    public function processPayment($payment)
    {
        if (is_array($payment)) {
            $payment = RequestCreator::create(ProcessPaymentRequest::class, $payment);
        }

        ObjectRecursiveValidator::validate($payment);
        $paymentSerializer = new ProcessPaymentSerializer($payment);
        $paymentTransport = new ProcessPaymentTransport($paymentSerializer);

        return $this->execute($paymentTransport, ProcessPaymentResponse::class);
    }

    /**
     * @param string|GetPaymentRequest $paymentToken
     *
     * @return GetPaymentResponse|AbstractResponse
     *
     * @throws TransportException
     * @throws JsonParseException
     * @throws ResponseException
     * @throws ResponseParseException
     */
    public function getPayment($paymentToken)
    {
        if (!($paymentToken instanceof GetPaymentRequest)) {
            $paymentToken = new GetPaymentRequest($paymentToken);
        }

        ObjectRecursiveValidator::validate($paymentToken);
        $paymentSerializer = new GetPaymentSerializer($paymentToken);
        $paymentTransport = new GetPaymentTransport($paymentSerializer);

        return $this->execute($paymentTransport, GetPaymentResponse::class);
    }

    /**
     * @param string|CapturePaymentRequest $paymentToken
     *
     * @return CapturePaymentResponse|AbstractResponse
     *
     * @throws ResponseException
     * @throws TransportException
     * @throws ResponseParseException
     * @throws JsonParseException
     */
    public function capturePayment($paymentToken)
    {
        if (!$paymentToken instanceof CapturePaymentRequest) {
            $paymentToken = new CapturePaymentRequest($paymentToken);
        }

        ObjectRecursiveValidator::validate($paymentToken);
        $paymentSerializer = new CapturePaymentSerializer($paymentToken);
        $paymentTransport = new CapturePaymentTransport($paymentSerializer);

        return $this->execute($paymentTransport, CapturePaymentResponse::class);
    }

    /**
     * @param string|CancelPaymentRequest $paymentToken
     * @param string|null                 $reason
     *
     * @return CancelPaymentResponse|AbstractResponse
     *
     * @throws ResponseException
     * @throws TransportException
     * @throws ResponseParseException
     * @throws JsonParseException
     */
    public function cancelPayment($paymentToken, $reason = null)
    {
        if (!$paymentToken instanceof CancelPaymentRequest) {
            $paymentToken = new CancelPaymentRequest($paymentToken);
        }

        if ($reason !== null) {
            $paymentToken->setReason($reason);
        }

        ObjectRecursiveValidator::validate($paymentToken);
        $paymentSerializer = new CancelPaymentSerializer($paymentToken);
        $paymentTransport = new CancelPaymentTransport($paymentSerializer);

        return $this->execute($paymentTransport, CancelPaymentResponse::class);
    }

    /**
     * @param array|CreatePayoutRequest|AbstractRequest $payout
     *
     * @return CreatePayoutResponse|AbstractResponse
     *
     * @throws TransportException
     * @throws JsonParseException
     * @throws ResponseException
     * @throws ResponseParseException
     * @throws RequestParseException
     */
    public function createPayout($payout)
    {
        if (is_array($payout)) {
            $payout = RequestCreator::create(CreatePayoutRequest::class, $payout);
        }

        ObjectRecursiveValidator::validate($payout);
        $payoutSerializer = new CreatePayoutSerializer($payout);
        $payoutTransport = new CreatePayoutTransport($payoutSerializer);

        return $this->execute($payoutTransport, CreatePayoutResponse::class);
    }

    /**
     * @param int|array|GetPayoutRequest|GetPayoutRequestById|AbstractRequest $payoutParam
     *
     * @return GetPayoutResponse|AbstractResponse
     *
     * @throws TransportException
     * @throws JsonParseException
     * @throws ResponseException
     * @throws ResponseParseException
     * @throws RequestParseException
     */
    public function getPayout($payoutParam)
    {
        if (is_int($payoutParam)) {
            $payout = new GetPayoutRequestById($payoutParam);
        } else if (is_array($payoutParam)) {
            $payout = RequestCreator::create(GetPayoutRequest::class, $payoutParam);
        } else {
            $payout = $payoutParam;
        }

        ObjectRecursiveValidator::validate($payout);
        $payoutSerializer = new GetPayoutSerializer($payout);
        $payoutTransport = new GetPayoutTransport($payoutSerializer);

        return $this->execute($payoutTransport, GetPayoutResponse::class);
    }

    /**
     * @param array|GetSubscriptionRequest $subscriptionRequest
     *
     * @return AbstractResponse|GetSubscriptionResponse
     * @throws ResponseException
     * @throws TransportException
     */
    public function getSubscription($subscriptionRequest)
    {
        if (is_array($subscriptionRequest)) {
            $subscriptionRequest = RequestCreator::create(GetSubscriptionRequest::class, $subscriptionRequest);
        } else if (!($subscriptionRequest instanceof GetSubscriptionRequest)) {
            $subscriptionRequest = new GetSubscriptionRequest($subscriptionRequest);
        }

        ObjectRecursiveValidator::validate($subscriptionRequest);
        $serializer = new GetSubscriptionSerializer($subscriptionRequest);
        $transport = new GetSubscriptionTransport($serializer);

        return $this->execute($transport, GetSubscriptionResponse::class);
    }

    /**
     * @param array|CreateRefundRequest $request
     *
     * @return AbstractResponse|CreateRefundResponse
     * @throws ResponseException
     * @throws TransportException
     */
    public function createRefund($request)
    {
        if (!($request instanceof CreateRefundRequest)) {
            $request = RequestCreator::create(CreateRefundRequest::class, $request);
        }

        ObjectRecursiveValidator::validate($request);
        $serializer = new CreateRefundSerializer($request);
        $transport = new CreateRefundTransport($serializer);

        return $this->execute($transport, CreateRefundResponse::class);
    }

    /**
     * @param string|array|GetRefundRequest $request
     *
     * @return AbstractResponse|GetRefundResponse
     * @throws ResponseException
     * @throws TransportException
     */
    public function getRefund($request)
    {
        if (is_array($request)) {
            $request = RequestCreator::create(GetSubscriptionRequest::class, $request);
        } else if (!($request instanceof GetRefundRequest)) {
            $request = new GetRefundRequest($request);
        }

        ObjectRecursiveValidator::validate($request);
        $serializer = new GetRefundSerializer($request);
        $transport = new GetRefundTransport($serializer);

        return $this->execute($transport, GetRefundResponse::class);
    }

    /**
     * @param array|PaymentsReportRequest $paymentsReport
     *
     * @return $this|Psr7\MessageTrait
     *
     * @throws TransportException
     */
    public function getPaymentsReport($paymentsReport)
    {
        if (!($paymentsReport instanceof PaymentsReportRequest)) {
            $paymentsReport = RequestCreator::create(PaymentsReportRequest::class, $paymentsReport);
        }

        ObjectRecursiveValidator::validate($paymentsReport);
        $paymentsReportSerializer = new PaymentsReportSerializer($paymentsReport);
        $paymentsReportTransport = new PaymentsReportTransport($paymentsReportSerializer);

        $filename = [];
        $filename[] = 'payments_report';
        $filename[] = $paymentsReport->getDatetimeFrom()->format('Y-m-d-H-i-s');
        $filename[] = '_';
        $filename[] = $paymentsReport->getDatetimeTo()->format('Y-m-d-H-i-s');
        $filename[] = '.csv';

        return $this->download($paymentsReportTransport, join($filename));
    }

    /**
     * @param array|PayoutsReportRequest $payoutsReport
     *
     * @return Psr7\MessageTrait
     * @throws TransportException
     */
    public function getPayoutsReport($payoutsReport)
    {
        if (!($payoutsReport instanceof PayoutsReportRequest)) {
            $payoutsReport = RequestCreator::create(PayoutsReportRequest::class, $payoutsReport);
        }

        ObjectRecursiveValidator::validate($payoutsReport);
        $payoutsReportSerializer = new PayoutsReportSerializer($payoutsReport);
        $payoutsReportTransport = new PayoutsReportTransport($payoutsReportSerializer);

        $filename = [];
        $filename[] = '$payouts_report';
        $filename[] = $payoutsReport->getDatetimeFrom()->format('Y-m-d-H-i-s');
        $filename[] = '_';
        $filename[] = $payoutsReport->getDatetimeTo()->format('Y-m-d-H-i-s');
        $filename[] = '.csv';

        return $this->download($payoutsReportTransport, join($filename));
    }

    /**
     * @param string|WalletRequest $walletRequest
     *
     * @return AbstractResponse
     *
     * @throws ResponseException
     * @throws TransportException
     */
    public function getWalletInfo($walletRequest)
    {
        if (!$walletRequest instanceof WalletRequest) {
            $walletRequest = new WalletRequest($walletRequest);
        }

        ObjectRecursiveValidator::validate($walletRequest);
        $walletSerializer = new WalletSerializer($walletRequest);

        return $this->execute($walletRequest->getTransport($walletSerializer), WalletResponse::class);
    }

    /**
     * @param array|ApplePayVerifyRequest $verifyRequest
     *
     * @return ApplePayVerifyResponse|AbstractResponse
     * @throws ResponseException
     * @throws TransportException
     */
    public function verifyApplePay($verifyRequest)
    {
        if (!($verifyRequest instanceof ApplePayVerifyRequest)) {
            $verifyRequest = new ApplePayVerifyRequest($verifyRequest);
        }

        ObjectRecursiveValidator::validate($verifyRequest);
        $serializer = new ApplePayVerifySerializer($verifyRequest);
        $transport = new ApplePayVerifyTransport($serializer);

        return $this->execute($transport, ApplePayVerifyResponse::class);
    }

    public function getPayoutSbpMembers()
    {
        $request = new GetPayoutSbpMembersRequest();

        ObjectRecursiveValidator::validate($request);
        $serializer = new GetPayoutSbpMembersSerializer($request);
        $transport = new GetPayoutSbpMembersTransport($serializer);

        return $this->execute($transport, GetPayoutSbpMembersResponse::class);
    }

    /**
     * @param AbstractRequestTransport $requestTransport
     * @param string                   $responseType
     *
     * @return AbstractResponse
     *
     * @throws ResponseException
     * @throws TransportException
     * @throws ResponseParseException
     * @throws JsonParseException
     */
    protected function execute(AbstractRequestTransport $requestTransport, $responseType)
    {
        $response = $this->apiTransport->send(
            $requestTransport->getPath(),
            $requestTransport->getMethod(),
            $requestTransport->getQueryParams(),
            $requestTransport->getBodyForRequest(),
            $requestTransport->getHeaders()
        );

        if ($response->getStatusCode() != 200) {
            $this->processError($response); // throw ResponseException
        }

        $body = $response->getBody()->getContents();
        $headers = $response->getHeaders();
        $responseData = json_decode($body, true);

        if (!$responseData) {
            $errorCode = json_last_error();

            if ($errorCode === JSON_ERROR_NONE) {
                $errorCode = -1;
            }

            throw new JsonParseException('Decode response error', $errorCode, $headers ?: [], $body);
        }

        return ResponseCreator::create($responseType, $responseData);
    }

    /**
     * @param AbstractRequestTransport $requestTransport
     * @param string                   $filename
     *
     * @return Psr7\MessageTrait
     *
     * @throws TransportException
     */
    protected function download(AbstractRequestTransport $requestTransport, $filename)
    {
        $response = $this->apiTransport->send(
            $requestTransport->getPath(),
            $requestTransport->getMethod(),
            $requestTransport->getQueryParams(),
            $requestTransport->getBodyForRequest(),
            $requestTransport->getHeaders()
        );

        if ($response->getStatusCode() === 200) {
            return (new Psr7\Response())
                ->withHeader('Content-Type', 'text/csv; charset=utf-8')
                ->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->withBody($response->getBody());
        }

        return $response;
    }

    /**
     * @param Psr7\Response $response
     *
     * @throws ResponseException
     */
    protected function processError(Psr7\Response $response)
    {
        $content = $response->getBody()->getContents();

        switch ($response->getStatusCode()) {
            case BadRequestException::HTTP_CODE:
                throw new BadRequestException($response->getHeaders(), $content);
            case UnauthorizedException::HTTP_CODE:
                throw new UnauthorizedException($response->getHeaders(), $content);
            case ForbiddenException::HTTP_CODE:
                throw new ForbiddenException($response->getHeaders(), $content);
            case NotFoundException::HTTP_CODE:
                throw new NotFoundException($response->getHeaders(), $content);
            case RequestTimeoutException::HTTP_CODE:
                throw new RequestTimeoutException($response->getHeaders(), $content);
            case TooManyRequestsException::HTTP_CODE:
                throw new TooManyRequestsException($response->getHeaders(), $content);
            case InternalServerException::HTTP_CODE:
                throw new InternalServerException($response->getHeaders(), $content);
            default:
                throw new ResponseException(
                    'An unknown API error occurred',
                    $response->getStatusCode(),
                    $response->getHeaders(),
                    $content
                );
        }
    }
}
