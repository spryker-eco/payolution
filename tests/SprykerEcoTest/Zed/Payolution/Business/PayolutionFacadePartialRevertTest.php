<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Payolution\Business;

use Generated\Shared\Transfer\PayolutionOmsOperationRequestTransfer;
use Generated\Shared\Transfer\PayolutionTransactionResponseTransfer;
use SprykerEco\Zed\Payolution\Business\Payment\Method\ApiConfig;
use SprykerEcoTest\Zed\Payolution\Business\Api\Adapter\Http\PreAuthorizationAdapterMock;
use SprykerEcoTest\Zed\Payolution\Business\Api\Adapter\Http\ReversalAdapterMock;

/**
 * Auto-generated group annotations
 * @group SprykerEcoTest
 * @group Zed
 * @group Payolution
 * @group Business
 * @group Facade
 * @group PayolutionFacadeRevertTest
 * Add your own group annotations below this line
 */
class PayolutionFacadePartialRevertTest extends AbstractFacadeTest
{
    /**
     * @return void
     */
    public function testRevertPaymentWithSuccessResponse()
    {
        // Arrange
        $orderTransfer = $this->createOrderTransfer();
        $preAuthorizationAdapterMock = new PreAuthorizationAdapterMock();
        $preAuthorizationFacade = $this->getFacadeMock($preAuthorizationAdapterMock);
        $payolutionOmsOperationRequest = new PayolutionOmsOperationRequestTransfer();
        $payolutionOmsOperationRequest->setOrder($orderTransfer);
        $payolutionOmsOperationRequest->setIdPayment($this->getPaymentEntity()->getIdPaymentPayolution());
        $payolutionOmsOperationRequest->addSelectedItem($orderTransfer->getItems()[0]);
        $reversalAdapterMock = new ReversalAdapterMock();
        $reversalFacade = $this->getFacadeMock($reversalAdapterMock);

        // Act
        $preAuthorizationResponse = $preAuthorizationFacade->preAuthorizePartialPayment($payolutionOmsOperationRequest);
        $response = $reversalFacade->revertPartialPayment($payolutionOmsOperationRequest);

        // Assert
        $this->assertEquals(true, $reversalFacade->isReversalApproved($orderTransfer));
        $this->assertInstanceOf(PayolutionTransactionResponseTransfer::class, $response);

        $expectedResponseData = $reversalAdapterMock->getSuccessResponse();
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
        $this->assertEquals(2, $this->getRequestLogCollectionForPayment()->count());
        $this->assertEquals(ApiConfig::PAYMENT_CODE_REVERSAL, $requestLog->getPaymentCode());
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
    public function testRevertPaymentWithFailureResponse()
    {
        // Arrange
        $orderTransfer = $this->createOrderTransfer();
        $payolutionOmsOperationRequest = new PayolutionOmsOperationRequestTransfer();
        $payolutionOmsOperationRequest->setOrder($orderTransfer);
        $payolutionOmsOperationRequest->setIdPayment($this->getPaymentEntity()->getIdPaymentPayolution());
        $payolutionOmsOperationRequest->addSelectedItem($orderTransfer->getItems()[0]);
        $preAuthorizationAdapterMock = new PreAuthorizationAdapterMock();
        $preAuthorizationFacade = $this->getFacadeMock($preAuthorizationAdapterMock);
        $adapterMock = new ReversalAdapterMock();
        $adapterMock->expectFailure();
        $reversalFacade = $this->getFacadeMock($adapterMock);

        // Act
        $preAuthorizationResponse = $preAuthorizationFacade->preAuthorizePartialPayment($payolutionOmsOperationRequest);
        $response = $reversalFacade->revertPartialPayment($payolutionOmsOperationRequest);

        // Assert
        $this->assertEquals(false, $reversalFacade->isReversalApproved($orderTransfer));
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
        $this->assertEquals(2, $this->getRequestLogCollectionForPayment()->count());
        $this->assertEquals(ApiConfig::PAYMENT_CODE_REVERSAL, $requestLog->getPaymentCode());
        $this->assertEquals(4, $requestLog->getPresentationAmount());
        $this->assertEquals($preAuthorizationResponse->getIdentificationUniqueid(), $requestLog->getReferenceId());

        /** @var \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLog $statusLog */
        $statusLog = $this->getStatusLogCollectionForPayment()->getLast();
        $this->assertEquals(2, $this->getStatusLogCollectionForPayment()->count());
        $this->matchStatusLogWithResponse($statusLog, $expectedResponse);
    }
}
