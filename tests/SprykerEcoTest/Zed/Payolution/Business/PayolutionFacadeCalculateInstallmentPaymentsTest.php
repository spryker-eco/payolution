<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Payolution\Business;

use Generated\Shared\Transfer\PayolutionCalculationResponseTransfer;
use SprykerEco\Shared\Payolution\PayolutionConfig;
use SprykerEcoTest\Zed\Payolution\Business\Api\Adapter\Http\CalculateInstallmentAdapterMock;

/**
 * Auto-generated group annotations
 * @group SprykerEcoTest
 * @group Zed
 * @group Payolution
 * @group Business
 * @group Facade
 * @group PayolutionFacadeCalculateInstallmentPaymentsTest
 * Add your own group annotations below this line
 */
class PayolutionFacadeCalculateInstallmentPaymentsTest extends AbstractFacadeTest
{
    /**
     * @return void
     */
    public function testCalculateInstallmentPayments()
    {
        $quoteTransfer = $this->createCheckoutRequestTransfer(PayolutionConfig::BRAND_INSTALLMENT);

        $adapterMock = new CalculateInstallmentAdapterMock();
        $facade = $this->getFacadeMock($adapterMock);
        $response = $facade->calculateInstallmentPayments($quoteTransfer);

        $this->assertInstanceOf(PayolutionCalculationResponseTransfer::class, $response);

        $firstInstallment = $response->getPaymentDetails()[0];

        $expectedResponseData = $adapterMock->sendAuthorizedRequest('foo', 'bar', 'baz');
        $expectedResponse = $this->getResponseConverter()->toCalculationResponseTransfer($expectedResponseData);

        $this->assertEquals($expectedResponse->toArray(), $response->toArray());
        $this->assertEquals($expectedResponse->getPaymentDetails()->count(), $expectedResponse->getPaymentDetails()->count());
        $this->assertEquals($expectedResponse->getStatus(), $response->getStatus());
        $this->assertEquals($expectedResponse->getStatusCode(), $response->getStatusCode());
        $this->assertEquals($expectedResponse->getPaymentType(), $response->getPaymentType());
        $this->assertEquals($expectedResponse->getTransactionType(), $response->getTransactionType());
        $this->assertEquals($expectedResponse->getDescription(), $response->getDescription());
        $this->assertEquals($expectedResponse->getIdentificationTransactionid(), $response->getIdentificationTransactionid());
        $this->assertEquals($expectedResponse->getIdentificationUniqueid(), $response->getIdentificationUniqueid());

        $this->assertEquals($quoteTransfer->getTotals()->getSubtotal(), $firstInstallment->getOriginalAmount());
        $this->assertEquals($quoteTransfer->getTotals()->getGrandTotal(), $firstInstallment->getTotalAmount());

        $this->assertEquals($firstInstallment->getInstallments()->count(), $firstInstallment->getDuration());
    }
}
