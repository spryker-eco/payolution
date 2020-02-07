<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Payolution\Business\Payment\MethodMapper;

use Generated\Shared\Transfer\ItemTransfer;
use SprykerEco\Shared\Payolution\PayolutionConfig;
use SprykerEco\Zed\Payolution\Business\Payment\Method\ApiConfig;
use SprykerEco\Zed\Payolution\Business\Payment\Method\Installment\Installment;

/**
 * Auto-generated group annotations
 * @group SprykerEcoTest
 * @group Zed
 * @group Payolution
 * @group Business
 * @group Payment
 * @group MethodMapper
 * @group InstallmentTest
 * Add your own group annotations below this line
 */
class InstallmentTest extends AbstractMethodMapperTest
{
    /**
     * @return void
     */
    public function testMapToPreCheck()
    {
        // Arrange
        $quoteTransfer = $this->createQuoteTransfer(PayolutionConfig::BRAND_INSTALLMENT);
        $methodMapper = new Installment($this->getPayolutionConfigMock(), $this->getMoneyFacade());

        // Act
        $requestData = $methodMapper->buildPreCheckRequest($quoteTransfer);

        // Assert
        $this->assertSame(PayolutionConfig::BRAND_INSTALLMENT, $requestData['ACCOUNT.BRAND']);
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
        // Arrange
        $methodMapper = new Installment($this->getPayolutionConfigMock(), $this->getMoneyFacade());
        $paymentEntityMock = $this->getPaymentEntityMock(PayolutionConfig::BRAND_INSTALLMENT);
        $orderTransfer = $this->createOrderTransfer();

        // Act
        $requestData = $methodMapper->buildPreAuthorizationRequest($orderTransfer, $paymentEntityMock, []);

        // Assert
        $this->assertSame($paymentEntityMock->getEmail(), $requestData['CONTACT.EMAIL']);
        $this->assertSame(PayolutionConfig::BRAND_INSTALLMENT, $requestData['ACCOUNT.BRAND']);
        $this->assertSame(ApiConfig::PAYMENT_CODE_PRE_AUTHORIZATION, $requestData['PAYMENT.CODE']);
    }

    /**
     * @return void
     */
    public function testMapToReAuthorization()
    {
        // Arrange
        $uniqueId = $this->createRandomString();
        $methodMapper = new Installment($this->getPayolutionConfigMock(), $this->getMoneyFacade());
        $paymentEntityMock = $this->getPaymentEntityMock(PayolutionConfig::BRAND_INSTALLMENT);
        $orderTransfer = $this->createOrderTransfer();

        // Act
        $requestData = $methodMapper->buildReAuthorizationRequest($orderTransfer, $paymentEntityMock, $uniqueId, []);

        // Assert
        $this->assertSame(PayolutionConfig::BRAND_INSTALLMENT, $requestData['ACCOUNT.BRAND']);
        $this->assertSame(ApiConfig::PAYMENT_CODE_RE_AUTHORIZATION, $requestData['PAYMENT.CODE']);
        $this->assertSame($uniqueId, $requestData['IDENTIFICATION.REFERENCEID']);

        // Arrange
        $itemTransfer = new ItemTransfer();
        $itemTransfer->setIdSalesOrderItem(1);

        // Act
        $requestData = $methodMapper->buildCaptureRequest($orderTransfer, $paymentEntityMock, $uniqueId, [$itemTransfer]);

        // Assert
        $this->assertSame(PayolutionConfig::BRAND_INSTALLMENT, $requestData['ACCOUNT.BRAND']);
        $this->assertSame(ApiConfig::PAYMENT_CODE_CAPTURE, $requestData['PAYMENT.CODE']);
        $this->assertSame($uniqueId, $requestData['IDENTIFICATION.REFERENCEID']);
        $this->assertSame(5.0, $requestData['PRESENTATION.AMOUNT']);
    }

    /**
     * @return void
     */
    public function testMapToReversal()
    {
        // Arrange
        $uniqueId = $this->createRandomString();
        $methodMapper = new Installment($this->getPayolutionConfigMock(), $this->getMoneyFacade());
        $paymentEntityMock = $this->getPaymentEntityMock(PayolutionConfig::BRAND_INSTALLMENT);
        $orderTransfer = $this->createOrderTransfer();

        // Act
        $requestData = $methodMapper->buildRevertRequest($orderTransfer, $paymentEntityMock, $uniqueId, []);

        // Assert
        $this->assertSame(PayolutionConfig::BRAND_INSTALLMENT, $requestData['ACCOUNT.BRAND']);
        $this->assertSame(ApiConfig::PAYMENT_CODE_REVERSAL, $requestData['PAYMENT.CODE']);
        $this->assertSame($uniqueId, $requestData['IDENTIFICATION.REFERENCEID']);

        // Arrange
        $itemTransfer = new ItemTransfer();
        $itemTransfer->setIdSalesOrderItem(1);

        // Act
        $requestData = $methodMapper->buildCaptureRequest($orderTransfer, $paymentEntityMock, $uniqueId, [$itemTransfer]);

        // Assert
        $this->assertSame(PayolutionConfig::BRAND_INSTALLMENT, $requestData['ACCOUNT.BRAND']);
        $this->assertSame(ApiConfig::PAYMENT_CODE_CAPTURE, $requestData['PAYMENT.CODE']);
        $this->assertSame($uniqueId, $requestData['IDENTIFICATION.REFERENCEID']);
        $this->assertSame(5.0, $requestData['PRESENTATION.AMOUNT']);
    }

    /**
     * @return void
     */
    public function testMapToCapture()
    {
        // Arrange
        $uniqueId = $this->createRandomString();
        $methodMapper = new Installment($this->getPayolutionConfigMock(), $this->getMoneyFacade());
        $paymentEntityMock = $this->getPaymentEntityMock(PayolutionConfig::BRAND_INSTALLMENT);
        $orderTransfer = $this->createOrderTransfer();

        // Act
        $requestData = $methodMapper->buildCaptureRequest($orderTransfer, $paymentEntityMock, $uniqueId, []);

        // Assert
        $this->assertSame(PayolutionConfig::BRAND_INSTALLMENT, $requestData['ACCOUNT.BRAND']);
        $this->assertSame(ApiConfig::PAYMENT_CODE_CAPTURE, $requestData['PAYMENT.CODE']);
        $this->assertSame($uniqueId, $requestData['IDENTIFICATION.REFERENCEID']);

        // Arrange
        $itemTransfer = new ItemTransfer();
        $itemTransfer->setIdSalesOrderItem(1);

        // Act
        $requestData = $methodMapper->buildCaptureRequest($orderTransfer, $paymentEntityMock, $uniqueId, [$itemTransfer]);

        // Assert
        $this->assertSame(PayolutionConfig::BRAND_INSTALLMENT, $requestData['ACCOUNT.BRAND']);
        $this->assertSame(ApiConfig::PAYMENT_CODE_CAPTURE, $requestData['PAYMENT.CODE']);
        $this->assertSame($uniqueId, $requestData['IDENTIFICATION.REFERENCEID']);
        $this->assertSame(5.0, $requestData['PRESENTATION.AMOUNT']);
    }

    /**
     * @return void
     */
    public function testMapToRefund()
    {
        // Arrange
        $uniqueId = $this->createRandomString();
        $methodMapper = new Installment($this->getPayolutionConfigMock(), $this->getMoneyFacade());
        $paymentEntityMock = $this->getPaymentEntityMock(PayolutionConfig::BRAND_INSTALLMENT);
        $orderTransfer = $this->createOrderTransfer();

        // Act
        $requestData = $methodMapper->buildRefundRequest($orderTransfer, $paymentEntityMock, $uniqueId);

        // Assert
        $this->assertSame(PayolutionConfig::BRAND_INSTALLMENT, $requestData['ACCOUNT.BRAND']);
        $this->assertSame(ApiConfig::PAYMENT_CODE_REFUND, $requestData['PAYMENT.CODE']);
        $this->assertSame($uniqueId, $requestData['IDENTIFICATION.REFERENCEID']);
    }
}
