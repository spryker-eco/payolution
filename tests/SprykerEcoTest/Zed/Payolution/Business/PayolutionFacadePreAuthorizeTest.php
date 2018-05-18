<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Payolution\Business;

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
class PayolutionFacadePreAuthorizeTest extends AbstractFacadeTest
{
    /**
     * @return void
     */
    public function testPreAuthorizePaymentWithSuccessResponse()
    {
        $orderTransfer = $this->createOrderTransfer();

        $adapterMock = new PreAuthorizationAdapterMock();
        $facade = $this->getFacadeMock($adapterMock);
        $response = $facade->preAuthorizePayment($orderTransfer, $this->getPaymentEntity()->getIdPaymentPayolution());

        $isApproved = $facade->isPreAuthorizationApproved($orderTransfer);
        $this->assertEquals(true, $isApproved);

        $this->assertInstanceOf(PayolutionTransactionResponseTransfer::class, $response);

        $expectedResponseData = $adapterMock->getSuccessResponse();
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
        $this->assertEquals($orderTransfer->getTotals()->getGrandTotal() / 100, $requestLog->getPresentationAmount());
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
        $orderTransfer = $this->createOrderTransfer();
        $adapterMock = (new PreAuthorizationAdapterMock())->expectFailure();
        $facade = $this->getFacadeMock($adapterMock);
        $response = $facade->preAuthorizePayment($orderTransfer, $this->getPaymentEntity()->getIdPaymentPayolution());

        $isApproved = $facade->isPreAuthorizationApproved($orderTransfer);
        $this->assertEquals(false, $isApproved);

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
