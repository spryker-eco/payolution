<?php

/**
 * This file is part of the Spryker Platform.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Functional\Spryker\Zed\Payolution\Business;

use Functional\Spryker\Zed\Payolution\Business\Api\Adapter\Http\PreAuthorizationAdapterMock;
use Functional\Spryker\Zed\Payolution\Business\Api\Adapter\Http\ReversalAdapterMock;
use Spryker\Zed\Payolution\Business\Payment\Method\ApiConstants;

class PayolutionFacadeRevertTest extends AbstractFacadeTest
{

    /**
     * @return void
     */
    public function testRevertPaymentWithSuccessResponse()
    {
        $orderTransfer = $this->createOrderTransfer();
        $idPayment = $this->getPaymentEntity()->getIdPaymentPayolution();
        $preAuthorizationAdapterMock = new PreAuthorizationAdapterMock();
        $facade = $this->getFacadeMock($preAuthorizationAdapterMock);
        $preAuthorizationResponse = $facade->preAuthorizePayment($orderTransfer, $idPayment);

        $adapterMock = new ReversalAdapterMock();
        $facade = $this->getFacadeMock($adapterMock);
        $response = $facade->revertPayment($orderTransfer, $idPayment);

        $this->assertInstanceOf('Generated\Shared\Transfer\PayolutionTransactionResponseTransfer', $response);

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
        $this->assertEquals(2, $this->getRequestLogCollectionForPayment()->count());
        $this->assertEquals(ApiConstants::PAYMENT_CODE_REVERSAL, $requestLog->getPaymentCode());
        $this->assertEquals($orderTransfer->getTotals()->getGrandTotal() / 100, $requestLog->getPresentationAmount());
        $this->assertEquals($preAuthorizationResponse->getIdentificationUniqueid(), $requestLog->getReferenceId());

        /** @var \Orm\Zed\Payolution\Persistence\Base\SpyPaymentPayolutionTransactionStatusLog $statusLog */
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
        $orderTransfer = $this->createOrderTransfer();
        $idPayment = $this->getPaymentEntity()->getIdPaymentPayolution();
        $adapterMock = new PreAuthorizationAdapterMock();
        $facade = $this->getFacadeMock($adapterMock);
        $preAuthorizationResponse = $facade->preAuthorizePayment($orderTransfer, $idPayment);

        $adapterMock = new ReversalAdapterMock();
        $adapterMock->expectFailure();
        $facade = $this->getFacadeMock($adapterMock);
        $response = $facade->revertPayment($orderTransfer, $idPayment);

        $this->assertInstanceOf('Generated\Shared\Transfer\PayolutionTransactionResponseTransfer', $response);

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
        $this->assertEquals(ApiConstants::PAYMENT_CODE_REVERSAL, $requestLog->getPaymentCode());
        $this->assertEquals($orderTransfer->getTotals()->getGrandTotal() / 100, $requestLog->getPresentationAmount());
        $this->assertEquals($preAuthorizationResponse->getIdentificationUniqueid(), $requestLog->getReferenceId());

        /** @var \Orm\Zed\Payolution\Persistence\Base\SpyPaymentPayolutionTransactionStatusLog $statusLog */
        $statusLog = $this->getStatusLogCollectionForPayment()->getLast();
        $this->assertEquals(2, $this->getStatusLogCollectionForPayment()->count());
        $this->matchStatusLogWithResponse($statusLog, $expectedResponse);
    }

}
