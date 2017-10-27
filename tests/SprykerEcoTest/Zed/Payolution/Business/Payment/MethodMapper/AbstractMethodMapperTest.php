<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Payolution\Business\Payment\MethodMapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\PayolutionPaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\TotalsTransfer;
use Orm\Zed\Payolution\Persistence\Map\SpyPaymentPayolutionTableMap;
use Orm\Zed\Payolution\Persistence\SpyPaymentPayolution;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Service\UtilText\UtilTextService;
use Spryker\Zed\Money\Business\MoneyFacade;
use SprykerEco\Zed\Payolution\Dependency\Facade\PayolutionToMoneyBridge;
use SprykerEco\Zed\Payolution\PayolutionConfig;

/**
 * Auto-generated group annotations
 * @group SprykerEcoTest
 * @group Zed
 * @group Payolution
 * @group Business
 * @group Payment
 * @group MethodMapper
 * @group AbstractMethodMapperTest
 * Add your own group annotations below this line
 */
class AbstractMethodMapperTest extends Unit
{
    /**
     * @param string $accountBrand
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function createQuoteTransfer($accountBrand)
    {
        $quoteTransfer = new QuoteTransfer();

        $totalsTransfer = new TotalsTransfer();
        $totalsTransfer
            ->setGrandTotal(10000)
            ->setSubtotal(10000);

        $quoteTransfer->setTotals($totalsTransfer);

        $addressTransfer = new AddressTransfer();
        $addressTransfer
            ->setFirstName('John')
            ->setLastName('Doe')
            ->setSalutation('Mr')
            ->setCity('Berlin')
            ->setIso2Code('DE')
            ->setAddress1('Straße des 17. Juni')
            ->setAddress2('135')
            ->setZipCode('10623');

        $quoteTransfer->setBillingAddress($addressTransfer);

        $paymentTransfer = new PayolutionPaymentTransfer();
        $paymentTransfer
            ->setGender('Male')
            ->setDateOfBirth('1970-01-01')
            ->setClientIp('127.0.0.1')
            ->setAccountBrand($accountBrand)
            ->setAddress($addressTransfer);

        $payment = new PaymentTransfer();
        $payment->setPayolution($paymentTransfer);
        $quoteTransfer->setPayment($payment);

        return $quoteTransfer;
    }

    /**
     * @return string
     */
    protected function createRandomString()
    {
        $utilTextService = new UtilTextService();

        return 'test_' . $utilTextService->generateRandomString(32);
    }

    /**
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    protected function createOrderTransfer()
    {
        $orderTransfer = new OrderTransfer();
        $totalTransfer = new TotalsTransfer();
        $totalTransfer->setGrandTotal(1000);
        $orderTransfer->setTotals($totalTransfer);

        return $orderTransfer;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\SprykerEco\Zed\Payolution\PayolutionConfig
     */
    protected function getPayolutionConfigMock()
    {
        return $this->getMockBuilder(PayolutionConfig::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @param string $accountBrand
     *
     * @return \Orm\Zed\Payolution\Persistence\SpyPaymentPayolution
     */
    protected function getPaymentEntityMock($accountBrand)
    {
        $orderEntityMock = $this->getMockBuilder(SpySalesOrder::class)->getMock();

        /** @var \Orm\Zed\Payolution\Persistence\SpyPaymentPayolution|\PHPUnit_Framework_MockObject_MockObject $paymentEntityMock */
        $paymentEntityMock = $this->getMockBuilder(SpyPaymentPayolution::class)
            ->setMethods([
                'getSpySalesOrder',
            ])
            ->getMock();

        $paymentEntityMock
            ->expects($this->any())
            ->method('getSpySalesOrder')
            ->will($this->returnValue($orderEntityMock));

        $paymentEntityMock
            ->setIdPaymentPayolution(1)
            ->setClientIp('127.0.0.1')
            ->setAccountBrand($accountBrand)
            ->setFirstName('John')
            ->setLastName('Doe')
            ->setEmail('john@doe.com')
            ->setSalutation('Mr')
            ->setDateOfBirth('1970-01-01')
            ->setCountryIso2Code('DE')
            ->setCity('Berlin')
            ->setStreet('Straße des 17. Juni 135')
            ->setZipCode('10623')
            ->setGender(SpyPaymentPayolutionTableMap::COL_GENDER_FEMALE);

        return $paymentEntityMock;
    }

    /**
     * @return \SprykerEco\Zed\Payolution\Dependency\Facade\PayolutionToMoneyInterface
     */
    protected function getMoneyFacade()
    {
        $payolutionToMoneyBridge = new PayolutionToMoneyBridge(new MoneyFacade());

        return $payolutionToMoneyBridge;
    }
}
