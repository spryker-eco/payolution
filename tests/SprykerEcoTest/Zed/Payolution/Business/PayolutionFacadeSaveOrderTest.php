<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Payolution\Business;

use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Orm\Zed\Payolution\Persistence\SpyPaymentPayolution;
use SprykerEco\Shared\Payolution\PayolutionConfig;
use SprykerEcoTest\Zed\Payolution\Business\Api\Adapter\Http\SaveOrderAdapterMock;

/**
 * Auto-generated group annotations
 * @group SprykerEcoTest
 * @group Zed
 * @group Payolution
 * @group Business
 * @group Facade
 * @group PayolutionFacadeSaveOrderTest
 * Add your own group annotations below this line
 */
class PayolutionFacadeSaveOrderTest extends AbstractFacadeTest
{
    /**
     * @return void
     */
    public function testSaveOrderPayment()
    {
        $quoteTransfer = $this->createCheckoutRequestTransfer(PayolutionConfig::BRAND_INVOICE);

        $orderTransfer = $this->createOrderTransfer();

        $checkoutResponseTransfer = new CheckoutResponseTransfer();
        $saveOrderTransfer = new SaveOrderTransfer();
        $saveOrderTransfer->setIdSalesOrder($orderTransfer->getIdSalesOrder());
        $checkoutResponseTransfer->setSaveOrder($saveOrderTransfer);

        $adapterMock = new SaveOrderAdapterMock();
        $facade = $this->getFacadeMock($adapterMock);

        $facade->saveOrderPayment($quoteTransfer, $checkoutResponseTransfer);

        $paymentEntity = $this->getOrderEntity()
            ->getSpyPaymentPayolutions()
            ->getFirst();

        $this->assertInstanceOf(SpyPaymentPayolution::class, $paymentEntity);
        $this->assertEquals(PayolutionConfig::BRAND_INVOICE, $paymentEntity->getAccountBrand());
        $this->assertEquals('127.0.0.1', $paymentEntity->getClientIp());
    }
}
