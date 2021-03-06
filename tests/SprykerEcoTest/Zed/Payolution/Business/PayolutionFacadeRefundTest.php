<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Payolution\Business;

use Generated\Shared\Transfer\PayolutionTransactionResponseTransfer;
use SprykerEco\Zed\Payolution\Business\Payment\Method\ApiConfig;
use SprykerEcoTest\Zed\Payolution\Business\Api\Adapter\Http\CaptureAdapterMock;
use SprykerEcoTest\Zed\Payolution\Business\Api\Adapter\Http\PreAuthorizationAdapterMock;
use SprykerEcoTest\Zed\Payolution\Business\Api\Adapter\Http\RefundAdapterMock;

/**
 * Auto-generated group annotations
 * @group SprykerEcoTest
 * @group Zed
 * @group Payolution
 * @group Business
 * @group Facade
 * @group PayolutionFacadeRefundTest
 * Add your own group annotations below this line
 */
class PayolutionFacadeRefundTest extends AbstractFacadeTest
{
    /**
     * @return void
     */
    public function testRefundPaymentWithSuccessResponse()
    {
        $orderTransfer = $this->createOrderTransfer();
        $idPayment = $this->getPaymentEntity()->getIdPaymentPayolution();
        $preAuthorizationAdapterMock = new PreAuthorizationAdapterMock();
        $facade = $this->getFacadeMock($preAuthorizationAdapterMock);
        $preAuthorizationResponse = $facade->preAuthorizePayment($orderTransfer, $idPayment);

        $captureAdapterMock = new CaptureAdapterMock();
        $facade = $this->getFacadeMock($captureAdapterMock);
        $captureResponse = $facade->capturePayment($orderTransfer, $idPayment);

        $this->assertInstanceOf(PayolutionTransactionResponseTransfer::class, $captureResponse);

        $adapterMock = new RefundAdapterMock();
        $facade = $this->getFacadeMock($adapterMock);
        $response = $facade->refundPayment($orderTransfer, $idPayment);

        $isApproved = $facade->isRefundApproved($orderTransfer);
        $this->assertEquals(true, $isApproved);

        $this->assertInstanceOf(PayolutionTransactionResponseTransfer::class, $response);

        $expectedResponseData = $adapterMock->getSuccessResponse();
        $expectedResponse = $this->getResponseConverter()->toTransactionResponseTransfer($expectedResponseData);

        $this->assertEquals($expectedResponse, $response);
        $this->assertEquals($expectedResponse->getPaymentCode(), $response->getPaymentCode());
        $this->assertEquals($expectedResponse->getProcessingResult(), $response->getProcessingResult());
        $this->assertEquals($expectedResponse->getProcessingReasonCode(), $response->getProcessingReasonCode());
        $this->assertEquals($expectedResponse->getProcessingStatusCode(), $response->getProcessingStatusCode());
        $this->assertEquals(
            $preAuthorizationResponse->getIdentificationUniqueid(),
            $expectedResponse->getIdentificationReferenceid()
        );

        /** @var \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionRequestLog $requestLog */
        $requestLog = $this->getRequestLogCollectionForPayment()->getLast();
        $this->assertEquals(3, $this->getRequestLogCollectionForPayment()->count());
        $this->assertEquals(ApiConfig::PAYMENT_CODE_REFUND, $requestLog->getPaymentCode());
        $this->assertEquals($orderTransfer->getTotals()->getGrandTotal() / 100, $requestLog->getPresentationAmount());
        $this->assertEquals($preAuthorizationResponse->getIdentificationUniqueid(), $requestLog->getReferenceId());

        /** @var \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLog $statusLog */
        $statusLog = $this->getStatusLogCollectionForPayment()->getLast();
        $this->assertEquals(3, $this->getStatusLogCollectionForPayment()->count());
        $this->matchStatusLogWithResponse($statusLog, $expectedResponse);
        $this->assertNotNull($statusLog->getProcessingConnectordetailConnectortxid1());
        $this->assertNotNull($statusLog->getProcessingConnectordetailPaymentreference());
    }

    /**
     * @return void
     */
    public function testRefundPaymentWithFailureResponse()
    {
        $orderTransfer = $this->createOrderTransfer();
        $idPayment = $this->getPaymentEntity()->getIdPaymentPayolution();
        $preAuthorizationAdapterMock = new PreAuthorizationAdapterMock();
        $facade = $this->getFacadeMock($preAuthorizationAdapterMock);
        $preAuthorizationResponse = $facade->preAuthorizePayment($orderTransfer, $idPayment);

        $captureAdapterMock = new CaptureAdapterMock();
        $facade = $this->getFacadeMock($captureAdapterMock);
        $captureResponse = $facade->capturePayment($orderTransfer, $idPayment);

        $isApproved = $facade->isRefundApproved($orderTransfer);
        $this->assertEquals(false, $isApproved);

        $adapterMock = new RefundAdapterMock();
        $adapterMock->expectFailure();
        $facade = $this->getFacadeMock($adapterMock);
        $response = $facade->refundPayment($orderTransfer, $idPayment);

        $this->assertInstanceOf(PayolutionTransactionResponseTransfer::class, $response);

        $expectedResponseData = $adapterMock->getFailureResponse();
        $expectedResponse = $this->getResponseConverter()->toTransactionResponseTransfer($expectedResponseData);

        $this->assertEquals($expectedResponse, $response);
        $this->assertEquals($expectedResponse->getPaymentCode(), $response->getPaymentCode());
        $this->assertEquals($expectedResponse->getProcessingResult(), $response->getProcessingResult());
        $this->assertEquals($expectedResponse->getProcessingReasonCode(), $response->getProcessingReasonCode());
        $this->assertEquals($expectedResponse->getProcessingStatusCode(), $response->getProcessingStatusCode());
        $this->assertEquals(
            $preAuthorizationResponse->getIdentificationUniqueid(),
            $expectedResponse->getIdentificationReferenceid()
        );

        /** @var \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionRequestLog $requestLog */
        $requestLog = $this->getRequestLogCollectionForPayment()->getLast();
        $this->assertEquals(3, $this->getRequestLogCollectionForPayment()->count());
        $this->assertEquals(ApiConfig::PAYMENT_CODE_REFUND, $requestLog->getPaymentCode());
        $this->assertEquals($orderTransfer->getTotals()->getGrandTotal() / 100, $requestLog->getPresentationAmount());
        $this->assertEquals($preAuthorizationResponse->getIdentificationUniqueid(), $requestLog->getReferenceId());

        /** @var \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLog $statusLog */
        $statusLog = $this->getStatusLogCollectionForPayment()->getLast();
        $this->assertEquals(3, $this->getStatusLogCollectionForPayment()->count());
        $this->matchStatusLogWithResponse($statusLog, $expectedResponse);
    }
}
