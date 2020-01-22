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
use SprykerEcoTest\Zed\Payolution\Business\Api\Adapter\Http\ReAuthorizationAdapterMock;

/**
 * Auto-generated group annotations
 * @group SprykerEcoTest
 * @group Zed
 * @group Payolution
 * @group Business
 * @group Facade
 * @group PayolutionFacadeReAuthorizeTest
 * Add your own group annotations below this line
 */
class PayolutionFacadePartialReAuthorizeTest extends AbstractFacadeTest
{
    /**
     * @return void
     */
    public function testReAuthorizePaymentWithSuccessResponse()
    {
        // Arrange
        $orderTransfer = $this->createOrderTransfer();
        $payolutionOmsOperationRequestTransfer = new PayolutionOmsOperationRequestTransfer();
        $payolutionOmsOperationRequestTransfer->setOrder($orderTransfer);
        $payolutionOmsOperationRequestTransfer->setIdPayment($this->getPaymentEntity()->getIdPaymentPayolution());
        $payolutionOmsOperationRequestTransfer->addSelectedItem($orderTransfer->getItems()[0]);
        $preAuthorizationAdapterMock = new PreAuthorizationAdapterMock();
        $preAuthorizationFacade = $this->getFacadeMock($preAuthorizationAdapterMock);
        $reAuthorizationAdapterMock = new ReAuthorizationAdapterMock();
        $reAuthorizationFacade = $this->getFacadeMock($reAuthorizationAdapterMock);

        // Act
        $preAuthorizationResponse = $preAuthorizationFacade->preAuthorizePartialPayment(
            $payolutionOmsOperationRequestTransfer
        );
        $response = $reAuthorizationFacade->reAuthorizePartialPayment($payolutionOmsOperationRequestTransfer);

        // Assert
        $this->assertEquals(true, $reAuthorizationFacade->isReAuthorizationApproved($orderTransfer));
        $this->assertInstanceOf(PayolutionTransactionResponseTransfer::class, $response);
        $expectedResponseData = $reAuthorizationAdapterMock->getSuccessResponse();
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
        $this->assertEquals(ApiConfig::PAYMENT_CODE_RE_AUTHORIZATION, $requestLog->getPaymentCode());
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
    public function testPreAuthorizationWithFailureResponse()
    {
        // Arrange
        $orderTransfer = $this->createOrderTransfer();
        $payolutionOmsOperationRequestTransfer = new PayolutionOmsOperationRequestTransfer();
        $payolutionOmsOperationRequestTransfer->setOrder($orderTransfer);
        $payolutionOmsOperationRequestTransfer->setIdPayment($this->getPaymentEntity()->getIdPaymentPayolution());
        $payolutionOmsOperationRequestTransfer->addSelectedItem($orderTransfer->getItems()[0]);
        $preAuthorizationAdapterMock = new PreAuthorizationAdapterMock();
        $preAuthorizaztionFacade = $this->getFacadeMock($preAuthorizationAdapterMock);
        $reAuthorizationAdapterMock = new ReAuthorizationAdapterMock();
        $reAuthorizationAdapterMock->expectFailure();

        // Act
        $preAuthorizationResponse = $preAuthorizaztionFacade->preAuthorizePartialPayment($payolutionOmsOperationRequestTransfer);
        $reAuthorizationFacade = $this->getFacadeMock($reAuthorizationAdapterMock);
        $response = $reAuthorizationFacade->reAuthorizePartialPayment($payolutionOmsOperationRequestTransfer);

        // Assert
        $this->assertEquals(false, $reAuthorizationFacade->isReAuthorizationApproved($orderTransfer));
        $this->assertInstanceOf(PayolutionTransactionResponseTransfer::class, $response);
        $expectedResponseData = $reAuthorizationAdapterMock->getFailureResponse();
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
        $this->assertEquals(ApiConfig::PAYMENT_CODE_RE_AUTHORIZATION, $requestLog->getPaymentCode());
        $this->assertEquals(4, $requestLog->getPresentationAmount());
        $this->assertEquals($preAuthorizationResponse->getIdentificationUniqueid(), $requestLog->getReferenceId());

        /** @var \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLog $statusLog */
        $statusLog = $this->getStatusLogCollectionForPayment()->getLast();
        $this->assertEquals(2, $this->getStatusLogCollectionForPayment()->count());
        $this->matchStatusLogWithResponse($statusLog, $expectedResponse);
    }
}
