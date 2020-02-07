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

/**
 * Auto-generated group annotations
 * @group SprykerEcoTest
 * @group Zed
 * @group Payolution
 * @group Business
 * @group Facade
 * @group PayolutionFacadePreAuthorizeTest
 * Add your own group annotations below this line
 */
class PayolutionFacadePartialPreAuthorizeTest extends AbstractFacadeTest
{
    /**
     * @return void
     */
    public function testPreAuthorizePaymentWithSuccessResponse()
    {
        // Arrange
        $orderTransfer = $this->createOrderTransfer();
        $preAuthorizationAdapterMock = new PreAuthorizationAdapterMock();
        $facade = $this->getFacadeMock($preAuthorizationAdapterMock);
        $preAuthorizationFacade = $this->getFacadeMock($preAuthorizationAdapterMock);
        $payolutionOmsOperationRequestTransfer = new PayolutionOmsOperationRequestTransfer();
        $payolutionOmsOperationRequestTransfer->setOrder($orderTransfer);
        $payolutionOmsOperationRequestTransfer->setIdPayment($this->getPaymentEntity()->getIdPaymentPayolution());
        $payolutionOmsOperationRequestTransfer->addSelectedItem($orderTransfer->getItems()[0]);

        // Act
        $response = $preAuthorizationFacade->preAuthorizePartialPayment($payolutionOmsOperationRequestTransfer);
        $isApproved = $facade->isPreAuthorizationApproved($orderTransfer);

        // Assert
        $this->assertEquals(true, $isApproved);
        $this->assertInstanceOf(PayolutionTransactionResponseTransfer::class, $response);
        $expectedResponseData = $preAuthorizationAdapterMock->getSuccessResponse();
        $expectedResponse = $this->getResponseConverter()->toTransactionResponseTransfer($expectedResponseData);

        $this->assertEquals($expectedResponse, $response);
        $this->assertEquals($expectedResponse->getPaymentCode(), $response->getPaymentCode());
        $this->assertEquals($expectedResponse->getProcessingResult(), $response->getProcessingResult());
        $this->assertEquals($expectedResponse->getProcessingReasonCode(), $response->getProcessingReasonCode());
        $this->assertEquals($expectedResponse->getProcessingStatusCode(), $response->getProcessingStatusCode());

        /** @var \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionRequestLog $requestLog */
        $requestLog = $this->getRequestLogCollectionForPayment()->getLast();
        $this->assertEquals(1, $this->getRequestLogCollectionForPayment()->count());
        $this->assertEquals(ApiConfig::PAYMENT_CODE_PRE_AUTHORIZATION, $requestLog->getPaymentCode());
        $this->assertEquals(4, $requestLog->getPresentationAmount());
        $this->assertNull($requestLog->getReferenceId());

        /** @var \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLog $statusLog */
        $statusLog = $this->getStatusLogCollectionForPayment()->getLast();
        $this->assertEquals(1, $this->getStatusLogCollectionForPayment()->count());
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
        $adapterMock = (new PreAuthorizationAdapterMock())->expectFailure();
        $facade = $this->getFacadeMock($adapterMock);
        $payolutionOmsOperationRequestTransfer = new PayolutionOmsOperationRequestTransfer();
        $payolutionOmsOperationRequestTransfer->setOrder($orderTransfer);
        $payolutionOmsOperationRequestTransfer->setIdPayment($this->getPaymentEntity()->getIdPaymentPayolution());
        $payolutionOmsOperationRequestTransfer->addSelectedItem($orderTransfer->getItems()[0]);

        // Act
        $response = $facade->preAuthorizePartialPayment($payolutionOmsOperationRequestTransfer);

        // Assert
        $this->assertEquals(false, $facade->isPreAuthorizationApproved($orderTransfer));
        $expectedResponseData = $adapterMock->getFailureResponse();
        $expectedResponse = $this->getResponseConverter()->toTransactionResponseTransfer($expectedResponseData);

        $this->assertEquals($expectedResponse, $response);
        $this->assertEquals($expectedResponse->getPaymentCode(), $response->getPaymentCode());
        $this->assertEquals($expectedResponse->getProcessingResult(), $response->getProcessingResult());
        $this->assertEquals($expectedResponse->getProcessingReasonCode(), $response->getProcessingReasonCode());
        $this->assertEquals($expectedResponse->getProcessingStatusCode(), $response->getProcessingStatusCode());

        /** @var \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLog $statusLog */
        $statusLog = $this->getStatusLogCollectionForPayment()->getLast();
        $this->assertEquals(1, $this->getStatusLogCollectionForPayment()->count());
        $this->matchStatusLogWithResponse($statusLog, $expectedResponse);
    }
}
