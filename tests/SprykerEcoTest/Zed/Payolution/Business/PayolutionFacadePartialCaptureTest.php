<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Payolution\Business;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\PayolutionOmsOperationRequestTransfer;
use Generated\Shared\Transfer\PayolutionTransactionResponseTransfer;
use SprykerEco\Zed\Payolution\Business\Payment\Method\ApiConfig;
use SprykerEcoTest\Zed\Payolution\Business\Api\Adapter\Http\CaptureAdapterMock;
use SprykerEcoTest\Zed\Payolution\Business\Api\Adapter\Http\PreAuthorizationAdapterMock;

/**
 * Auto-generated group annotations
 * @group SprykerEcoTest
 * @group Zed
 * @group Payolution
 * @group Business
 * @group Facade
 * @group PayolutionFacadeCaptureTest
 * Add your own group annotations below this line
 */
class PayolutionFacadePartialCaptureTest extends AbstractFacadeTest
{
    /**
     * @return void
     */
    public function testCapturePaymentWithSuccessResponse()
    {
        // Arrange
        $orderTransfer = $this->createOrderTransfer();
        $preAuthorizationAdapterMock = new PreAuthorizationAdapterMock();
        $preAuthorizationFacade = $this->getFacadeMock($preAuthorizationAdapterMock);
        $payolutionOmsOperationRequestTransfer = new PayolutionOmsOperationRequestTransfer();
        $payolutionOmsOperationRequestTransfer->setOrder($orderTransfer);
        $payolutionOmsOperationRequestTransfer->setIdPayment($this->getPaymentEntity()->getIdPaymentPayolution());
        $payolutionOmsOperationRequestTransfer->addSelectedItem($orderTransfer->getItems()[0]);
        $captureAdapterMock = new CaptureAdapterMock();
        $captureFacade = $this->getFacadeMock($captureAdapterMock);

        // Act
        $preAuthorizationResponse = $preAuthorizationFacade->preAuthorizePartialPayment($payolutionOmsOperationRequestTransfer);
        $response = $captureFacade->capturePartialPayment($payolutionOmsOperationRequestTransfer);

        // Assert
        $expectedResponseData = $captureAdapterMock->getSuccessResponse();
        $expectedResponse = $this->getResponseConverter()->toTransactionResponseTransfer($expectedResponseData);

        $this->assertEquals(true, $captureFacade->isCaptureApproved($orderTransfer));
        $this->assertInstanceOf(PayolutionTransactionResponseTransfer::class, $response);
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
        $this->assertEquals(2, $this->getRequestLogCollectionForPayment()->count());
        $this->assertEquals(ApiConfig::PAYMENT_CODE_CAPTURE, $requestLog->getPaymentCode());
        $this->assertEquals(4, $requestLog->getPresentationAmount());
        $this->assertEquals($preAuthorizationResponse->getIdentificationUniqueid(), $requestLog->getReferenceId());

        /** @var \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLog $statusLog */
        $statusLog = $this->getStatusLogCollectionForPayment()->getLast();
        $this->assertEquals(2, $this->getStatusLogCollectionForPayment()->count());
        $this->matchStatusLogWithResponse($statusLog, $expectedResponse);
        $this->assertNotNull($statusLog->getProcessingConnectordetailConnectortxid1());
        $this->assertNotNull($statusLog->getProcessingConnectordetailPaymentreference());
    }

    /**
     * @return void
     */
    public function testCapturePaymentWithFailureResponse()
    {
        // Arrange
        $orderTransfer = $this->createOrderTransfer();
        $idPayment = $this->getPaymentEntity()->getIdPaymentPayolution();
        $preAuthorizationAdapterMock = new PreAuthorizationAdapterMock();
        $preAuthorizationFacade = $this->getFacadeMock($preAuthorizationAdapterMock);
        $payolutionOmsOperationRequestTransfer = new PayolutionOmsOperationRequestTransfer();
        $payolutionOmsOperationRequestTransfer->setOrder($orderTransfer);
        $payolutionOmsOperationRequestTransfer->setIdPayment($idPayment);
        $payolutionOmsOperationRequestTransfer->addSelectedItem($orderTransfer->getItems()[0]);
        $captureAdapterMock = new CaptureAdapterMock();
        $captureAdapterMock->expectFailure();
        $captureFacade = $this->getFacadeMock($captureAdapterMock);

        // Act
        $preAuthorizationResponse = $preAuthorizationFacade->preAuthorizePartialPayment($payolutionOmsOperationRequestTransfer);
        $response = $captureFacade->capturePartialPayment($payolutionOmsOperationRequestTransfer);

        // Assert
        $expectedResponseData = $captureAdapterMock->getFailureResponse();
        $expectedResponse = $this->getResponseConverter()->toTransactionResponseTransfer($expectedResponseData);
        $this->assertEquals(false, $captureFacade->isCaptureApproved($orderTransfer));
        $this->assertInstanceOf(PayolutionTransactionResponseTransfer::class, $response);
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
        $this->assertEquals(2, $this->getRequestLogCollectionForPayment()->count());
        $this->assertEquals(ApiConfig::PAYMENT_CODE_CAPTURE, $requestLog->getPaymentCode());
        $this->assertEquals(4, $requestLog->getPresentationAmount());
        $this->assertEquals($preAuthorizationResponse->getIdentificationUniqueid(), $requestLog->getReferenceId());

        /** @var \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLog $statusLog */
        $statusLog = $this->getStatusLogCollectionForPayment()->getLast();
        $this->assertEquals(2, $this->getStatusLogCollectionForPayment()->count());
        $this->matchStatusLogWithResponse($statusLog, $expectedResponse);
    }
}
