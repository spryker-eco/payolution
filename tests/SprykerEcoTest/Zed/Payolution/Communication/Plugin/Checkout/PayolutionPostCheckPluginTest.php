<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Payolution\Communication\Plugin\Checkout;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLog;
use Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLogQuery;
use SprykerEco\Zed\Payolution\Business\Payment\Method\ApiConfig;
use SprykerEco\Zed\Payolution\Communication\Plugin\Checkout\PayolutionPostCheckPlugin;
use SprykerEco\Zed\Payolution\Persistence\PayolutionQueryContainer;

/**
 * Auto-generated group annotations
 * @group SprykerEcoTest
 * @group Zed
 * @group Payolution
 * @group Communication
 * @group Plugin
 * @group Checkout
 * @group PayolutionPostCheckPluginTest
 * Add your own group annotations below this line
 */
class PayolutionPostCheckPluginTest extends Unit
{
    protected const PROCESSING_SUCCESS_CODE = 'VA.PA.90.00';
    protected const PROCESSING_ERROR_CODE = 'error code';

    /**
     * @return void
     */
    public function testExecuteWithApprovedTransactionShouldNotAddErrorTransferToCheckoutResponseTransfer()
    {
        $transactionStatusLogEntity = $this->getTransactionStatusLogEntity();
        $transactionStatusLogEntity->setProcessingCode(self::PROCESSING_SUCCESS_CODE);

        $postCheckPlugin = new PayolutionPostCheckPlugin();
        $queryContainer = $this->getQueryContainerMock($transactionStatusLogEntity);
        $postCheckPlugin->setQueryContainer($queryContainer);

        $checkoutResponseTransfer = $this->getCheckoutResponseTransfer();
        $postCheckPlugin->execute(new QuoteTransfer(), $checkoutResponseTransfer);

        $this->assertTrue($checkoutResponseTransfer->getIsSuccess());
    }

    /**
     * @return void
     */
    public function testExecuteWithNotApprovedTransactionShouldAddErrorTransferToCheckoutResponseTransfer()
    {
        $transactionStatusLogEntity = $this->getTransactionStatusLogEntity();
        $transactionStatusLogEntity->setProcessingCode(self::PROCESSING_ERROR_CODE);

        $postCheckPlugin = new PayolutionPostCheckPlugin();
        $queryContainer = $this->getQueryContainerMock($transactionStatusLogEntity);
        $postCheckPlugin->setQueryContainer($queryContainer);

        $checkoutResponseTransfer = $this->getCheckoutResponseTransfer();
        $postCheckPlugin->execute(new QuoteTransfer(), $checkoutResponseTransfer);

        $this->assertFalse($checkoutResponseTransfer->getIsSuccess());
        $expectedError = $checkoutResponseTransfer->getErrors()[0];

        $this->assertSame(ApiConfig::CHECKOUT_ERROR_CODE_PAYMENT_FAILED, $expectedError->getErrorCode());
    }

    /**
     * @return \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLog
     */
    private function getTransactionStatusLogEntity()
    {
        return new SpyPaymentPayolutionTransactionStatusLog();
    }

    /**
     * @param \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLog $transactionStatusLogEntity
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|\SprykerEco\Zed\Payolution\Persistence\PayolutionQueryContainer
     */
    private function getQueryContainerMock(SpyPaymentPayolutionTransactionStatusLog $transactionStatusLogEntity)
    {
        $queryContainerMock = $this->getMockBuilder(PayolutionQueryContainer::class)->getMock();
        $transactionStatusLogQueryMock = $this->getTransactionStatusLogQueryMock($transactionStatusLogEntity);
        $queryContainerMock->expects($this->once())->method('queryTransactionStatusLogBySalesOrderId')->willReturn($transactionStatusLogQueryMock);

        return $queryContainerMock;
    }

    /**
     * @param \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLog $transactionStatusLogEntity
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|\Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLogQuery
     */
    private function getTransactionStatusLogQueryMock(SpyPaymentPayolutionTransactionStatusLog $transactionStatusLogEntity)
    {
        $transactionStatusLogQueryMock = $this->getMockBuilder(SpyPaymentPayolutionTransactionStatusLogQuery::class)->getMock();
        $transactionStatusLogQueryMock->method('findOne')->willReturn($transactionStatusLogEntity);

        return $transactionStatusLogQueryMock;
    }

    /**
     * @return \Generated\Shared\Transfer\CheckoutResponseTransfer
     */
    private function getCheckoutResponseTransfer()
    {
        $checkoutResponseTransfer = new CheckoutResponseTransfer();
        $checkoutResponseTransfer->setIsSuccess(true);

        $saveOrderTransfer = new SaveOrderTransfer();
        $saveOrderTransfer->setIdSalesOrder(23);

        $checkoutResponseTransfer->setSaveOrder($saveOrderTransfer);

        return $checkoutResponseTransfer;
    }
}
