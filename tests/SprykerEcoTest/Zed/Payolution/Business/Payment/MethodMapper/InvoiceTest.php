<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Payolution\Business\Payment\MethodMapper;

use SprykerEco\Shared\Payolution\PayolutionConfig;
use SprykerEco\Zed\Payolution\Business\Payment\Method\ApiConfig;
use SprykerEco\Zed\Payolution\Business\Payment\Method\Invoice\Invoice;

/**
 * Auto-generated group annotations
 * @group SprykerEcoTest
 * @group Zed
 * @group Payolution
 * @group Business
 * @group Payment
 * @group MethodMapper
 * @group InvoiceTest
 * Add your own group annotations below this line
 */
class InvoiceTest extends AbstractMethodMapperTest
{
    /**
     * @return void
     */
    public function testMapToPreCheck()
    {
        $quoteTransfer = $this->createQuoteTransfer(PayolutionConfig::BRAND_INVOICE);
        $methodMapper = new Invoice($this->getPayolutionConfigMock(), $this->getMoneyFacade());

        $requestData = $methodMapper->buildPreCheckRequest($quoteTransfer);

        $this->assertSame(PayolutionConfig::BRAND_INVOICE, $requestData['ACCOUNT.BRAND']);
        $this->assertSame(ApiConfig::PAYMENT_CODE_PRE_CHECK, $requestData['PAYMENT.CODE']);
        $this->assertSame('Straße des 17. Juni 135', $requestData['ADDRESS.STREET']);
        $this->assertSame(ApiConfig::CRITERION_PRE_CHECK, 'CRITERION.PAYOLUTION_PRE_CHECK');
        $this->assertSame('TRUE', $requestData['CRITERION.PAYOLUTION_PRE_CHECK']);
    }

    /**
     * @return void
     */
    public function testMapToPreAuthorization()
    {
        $methodMapper = new Invoice($this->getPayolutionConfigMock(), $this->getMoneyFacade());
        $paymentEntityMock = $this->getPaymentEntityMock(PayolutionConfig::BRAND_INVOICE);
        $orderTransfer = $this->createOrderTransfer();
        $requestData = $methodMapper->buildPreAuthorizationRequest($orderTransfer, $paymentEntityMock);

        $this->assertSame($paymentEntityMock->getEmail(), $requestData['CONTACT.EMAIL']);
        $this->assertSame(PayolutionConfig::BRAND_INVOICE, $requestData['ACCOUNT.BRAND']);
        $this->assertSame(ApiConfig::PAYMENT_CODE_PRE_AUTHORIZATION, $requestData['PAYMENT.CODE']);
    }

    /**
     * @return void
     */
    public function testMapToReAuthorization()
    {
        $uniqueId = $this->createRandomString();
        $methodMapper = new Invoice($this->getPayolutionConfigMock(), $this->getMoneyFacade());
        $paymentEntityMock = $this->getPaymentEntityMock(PayolutionConfig::BRAND_INVOICE);
        $orderTransfer = $this->createOrderTransfer();
        $requestData = $methodMapper->buildReAuthorizationRequest($orderTransfer, $paymentEntityMock, $uniqueId);

        $this->assertSame(PayolutionConfig::BRAND_INVOICE, $requestData['ACCOUNT.BRAND']);
        $this->assertSame(ApiConfig::PAYMENT_CODE_RE_AUTHORIZATION, $requestData['PAYMENT.CODE']);
        $this->assertSame($uniqueId, $requestData['IDENTIFICATION.REFERENCEID']);
    }

    /**
     * @return void
     */
    public function testMapToReversal()
    {
        $uniqueId = $this->createRandomString();
        $methodMapper = new Invoice($this->getPayolutionConfigMock(), $this->getMoneyFacade());
        $paymentEntityMock = $this->getPaymentEntityMock(PayolutionConfig::BRAND_INVOICE);
        $orderTransfer = $this->createOrderTransfer();
        $requestData = $methodMapper->buildRevertRequest($orderTransfer, $paymentEntityMock, $uniqueId);

        $this->assertSame(PayolutionConfig::BRAND_INVOICE, $requestData['ACCOUNT.BRAND']);
        $this->assertSame(ApiConfig::PAYMENT_CODE_REVERSAL, $requestData['PAYMENT.CODE']);
        $this->assertSame($uniqueId, $requestData['IDENTIFICATION.REFERENCEID']);
    }

    /**
     * @return void
     */
    public function testMapToCapture()
    {
        $uniqueId = $this->createRandomString();
        $methodMapper = new Invoice($this->getPayolutionConfigMock(), $this->getMoneyFacade());
        $paymentEntityMock = $this->getPaymentEntityMock(PayolutionConfig::BRAND_INVOICE);
        $orderTransfer = $this->createOrderTransfer();
        $requestData = $methodMapper->buildCaptureRequest($orderTransfer, $paymentEntityMock, $uniqueId);

        $this->assertSame(PayolutionConfig::BRAND_INVOICE, $requestData['ACCOUNT.BRAND']);
        $this->assertSame(ApiConfig::PAYMENT_CODE_CAPTURE, $requestData['PAYMENT.CODE']);
        $this->assertSame($uniqueId, $requestData['IDENTIFICATION.REFERENCEID']);
    }

    /**
     * @return void
     */
    public function testMapToRefund()
    {
        $uniqueId = $this->createRandomString();
        $methodMapper = new Invoice($this->getPayolutionConfigMock(), $this->getMoneyFacade());
        $paymentEntityMock = $this->getPaymentEntityMock(PayolutionConfig::BRAND_INVOICE);
        $orderTransfer = $this->createOrderTransfer();
        $requestData = $methodMapper->buildRefundRequest($orderTransfer, $paymentEntityMock, $uniqueId);

        $this->assertSame(PayolutionConfig::BRAND_INVOICE, $requestData['ACCOUNT.BRAND']);
        $this->assertSame(ApiConfig::PAYMENT_CODE_REFUND, $requestData['PAYMENT.CODE']);
        $this->assertSame($uniqueId, $requestData['IDENTIFICATION.REFERENCEID']);
    }
}
