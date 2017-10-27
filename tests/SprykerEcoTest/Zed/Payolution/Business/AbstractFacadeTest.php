<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Payolution\Business;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\PayolutionPaymentTransfer;
use Generated\Shared\Transfer\PayolutionTransactionResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\TotalsTransfer;
use Orm\Zed\Country\Persistence\SpyCountryQuery;
use Orm\Zed\Customer\Persistence\Map\SpyCustomerTableMap;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Orm\Zed\Payolution\Persistence\Map\SpyPaymentPayolutionTableMap;
use Orm\Zed\Payolution\Persistence\SpyPaymentPayolution;
use Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionRequestLogQuery;
use Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLog;
use Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLogQuery;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Orm\Zed\Sales\Persistence\SpySalesOrderAddress;
use Spryker\Zed\Money\Business\MoneyFacade;
use SprykerEco\Shared\Payolution\PayolutionConfig;
use SprykerEco\Zed\Payolution\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Payolution\Business\Api\Converter\Converter as ResponseConverter;
use SprykerEco\Zed\Payolution\Dependency\Facade\PayolutionToMoneyBridge;

/**
 * Auto-generated group annotations
 * @group SprykerEcoTest
 * @group Zed
 * @group Payolution
 * @group Business
 * @group Facade
 * @group AbstractFacadeTest
 * Add your own group annotations below this line
 */
class AbstractFacadeTest extends Unit
{
    /**
     * @var \Orm\Zed\Sales\Persistence\SpySalesOrder
     */
    private $orderEntity;

    /**
     * @var \Orm\Zed\Payolution\Persistence\SpyPaymentPayolution
     */
    private $paymentEntity;

    /**
     * @var \SprykerEco\Zed\Payolution\Business\Api\Converter\Converter
     */
    private $responseConverter;

    /**
     * @var \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionRequestLogQuery
     */
    private $requestLogQuery;

    /**
     * @var \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLogQuery
     */
    private $statusLogQuery;

    /**
     * @return void
     */
    protected function _before()
    {
        parent::_before();
        $this->setUpSalesOrderTestData();
        $this->setUpPaymentTestData();
        $this->responseConverter = new ResponseConverter($this->getMoneyFacade());
        $this->requestLogQuery = new SpyPaymentPayolutionTransactionRequestLogQuery();
        $this->statusLogQuery = new SpyPaymentPayolutionTransactionStatusLogQuery();
    }

    /**
     * @return \SprykerEco\Zed\Payolution\Dependency\Facade\PayolutionToMoneyInterface
     */
    protected function getMoneyFacade()
    {
        $payolutionToMoneyBridge = new PayolutionToMoneyBridge(new MoneyFacade());

        return $payolutionToMoneyBridge;
    }

    /**
     * @return void
     */
    protected function setUpSalesOrderTestData()
    {
        $country = SpyCountryQuery::create()->findOneByIso2Code('DE');

        $billingAddress = (new SpySalesOrderAddress())
            ->setFkCountry($country->getIdCountry())
            ->setFirstName('John')
            ->setLastName('Doe')
            ->setAddress1('Straße des 17. Juni 135')
            ->setCity('Berlin')
            ->setZipCode('10623');

        $billingAddress->save();

        $customer = (new SpyCustomerQuery())
            ->filterByFirstName('John')
            ->filterByLastName('Doe')
            ->filterByEmail('john@doe.com')
            ->filterByDateOfBirth('1970-01-01')
            ->filterByGender(SpyCustomerTableMap::COL_GENDER_MALE)
            ->filterByCustomerReference('payolution-pre-authorization-test')
            ->findOneOrCreate();

        $customer->save();

        $this->orderEntity = (new SpySalesOrder())
            ->setEmail('john@doe.com')
            ->setIsTest(true)
            ->setFkSalesOrderAddressBilling($billingAddress->getIdSalesOrderAddress())
            ->setFkSalesOrderAddressShipping($billingAddress->getIdSalesOrderAddress())
            ->setCustomerReference($customer->getCustomerReference())
            ->setOrderReference('foo-bar-baz-2');

        $this->orderEntity->save();
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
        $orderTransfer->setIdSalesOrder($this->orderEntity->getIdSalesOrder());

        return $orderTransfer;
    }

    /**
     * @return void
     */
    private function setUpPaymentTestData()
    {
        $this->paymentEntity = (new SpyPaymentPayolution())
            ->setFkSalesOrder($this->getOrderEntity()->getIdSalesOrder())
            ->setAccountBrand(PayolutionConfig::BRAND_INVOICE)
            ->setClientIp('127.0.0.1')
            ->setFirstName('Jane')
            ->setLastName('Doe')
            ->setDateOfBirth('1970-01-02')
            ->setEmail('jane@family-doe.org')
            ->setGender(SpyPaymentPayolutionTableMap::COL_GENDER_MALE)
            ->setSalutation(SpyPaymentPayolutionTableMap::COL_SALUTATION_MR)
            ->setCountryIso2Code('DE')
            ->setCity('Berlin')
            ->setStreet('Straße des 17. Juni 135')
            ->setZipCode('10623')
            ->setLanguageIso2Code('DE')
            ->setCurrencyIso3Code('EUR');
        $this->paymentEntity->save();
    }

    /**
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrder
     */
    protected function getOrderEntity()
    {
        return $this->orderEntity;
    }

    /**
     * @return \Orm\Zed\Payolution\Persistence\SpyPaymentPayolution
     */
    protected function getPaymentEntity()
    {
        return $this->paymentEntity;
    }

    /**
     * @return \SprykerEco\Zed\Payolution\Business\Api\Converter\Converter
     */
    protected function getResponseConverter()
    {
        return $this->responseConverter;
    }

    /**
     * @return \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionRequestLogQuery
     */
    protected function getRequestLogQuery()
    {
        return $this->requestLogQuery;
    }

    /**
     * @return \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLogQuery
     */
    protected function getStatusLogQuery()
    {
        return $this->statusLogQuery;
    }

    /**
     * @return \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionRequestLog[]|\Propel\Runtime\Collection\ObjectCollection
     */
    protected function getRequestLogCollectionForPayment()
    {
        return $this
            ->getRequestLogQuery()
            ->findByFkPaymentPayolution($this->getPaymentEntity()->getIdPaymentPayolution());
    }

    /**
     * @return \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLog[]|\Propel\Runtime\Collection\ObjectCollection
     */
    protected function getStatusLogCollectionForPayment()
    {
        return $this
            ->getStatusLogQuery()
            ->findByFkPaymentPayolution($this->getPaymentEntity()->getIdPaymentPayolution());
    }

    /**
     * @param \SprykerEco\Zed\Payolution\Business\Api\Adapter\AdapterInterface $adapter
     *
     * @return \SprykerEco\Zed\Payolution\Business\PayolutionFacade
     */
    protected function getFacadeMock(AdapterInterface $adapter)
    {
        return PayolutionFacadeMockBuilder::build($adapter, $this);
    }

    /**
     * @param \Orm\Zed\Payolution\Persistence\SpyPaymentPayolutionTransactionStatusLog $statusLog
     * @param \Generated\Shared\Transfer\PayolutionTransactionResponseTransfer $response
     *
     * @return void
     */
    protected function matchStatusLogWithResponse(
        SpyPaymentPayolutionTransactionStatusLog $statusLog,
        PayolutionTransactionResponseTransfer $response
    ) {
        $this->assertEquals($response->getProcessingCode(), $statusLog->getProcessingCode());
        $this->assertEquals($response->getProcessingResult(), $statusLog->getProcessingResult());
        $this->assertEquals($response->getProcessingStatus(), $statusLog->getProcessingStatus());
        $this->assertEquals($response->getProcessingStatusCode(), $statusLog->getProcessingStatusCode());
        $this->assertEquals($response->getProcessingReason(), $statusLog->getProcessingReason());
        $this->assertEquals($response->getProcessingReasonCode(), $statusLog->getProcessingReasonCode());
        $this->assertEquals($response->getProcessingReturn(), $statusLog->getProcessingReturn());
        $this->assertEquals($response->getProcessingReturnCode(), $statusLog->getProcessingReturnCode());
        $this->assertNotNull($statusLog->getIdentificationTransactionid());
        $this->assertNotNull($statusLog->getIdentificationUniqueid());
        $this->assertNotNull($statusLog->getIdentificationShortid());
        $this->assertNotNull($statusLog->getProcessingTimestamp());
    }

    /**
     * @param string $accountBrand
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function createCheckoutRequestTransfer($accountBrand)
    {
        $itemTransfer = new ItemTransfer();
        $itemTransfer
            ->setSku('1234567890')
            ->setQuantity(1)
            ->setUnitSubtotalAggregation(10000)
            ->setName('Socken');

        $billingAddressTransfer = new AddressTransfer();
        $billingAddressTransfer
            ->setIso2Code('DE')
            ->setEmail('john@doe.com')
            ->setFirstName('John')
            ->setLastName('Doe')
            ->setAddress1('Straße des 17. Juni')
            ->setAddress2('135')
            ->setZipCode('10623')
            ->setCity('Berlin');

        $shippingAddressTransfer = new AddressTransfer();
        $shippingAddressTransfer
            ->setIso2Code('DE')
            ->setEmail('john@doe.com')
            ->setFirstName('John')
            ->setLastName('Doe')
            ->setAddress1('Fraunhoferstraße')
            ->setAddress2('120')
            ->setZipCode('80469')
            ->setCity('München');

        $paymentAddressTransfer = new AddressTransfer();
        $paymentAddressTransfer
            ->setFirstName('John')
            ->setLastName('Doe')
            ->setSalutation('Mr')
            ->setEmail('john@doe.com')
            ->setCity('Berlin')
            ->setIso2Code('DE')
            ->setAddress1('Straße des 17. Juni')
            ->setAddress2('135')
            ->setZipCode('10623');

        $payolutionPaymentTransfer = new PayolutionPaymentTransfer();
        $payolutionPaymentTransfer
            ->setGender('Male')
            ->setDateOfBirth('1970-01-01')
            ->setClientIp('127.0.0.1')
            ->setAccountBrand($accountBrand)
            ->setAddress($paymentAddressTransfer);

        $quoteTransfer = new QuoteTransfer();

        $totalsTransfer = new TotalsTransfer();
        $totalsTransfer
            ->setGrandTotal(10000)
            ->setSubtotal(9000);

        $quoteTransfer->setTotals($totalsTransfer);

        $paymentTransfer = new PaymentTransfer();
        $paymentTransfer->setPaymentSelection('no_payment');
        $paymentTransfer->setPayolution($payolutionPaymentTransfer);
        $quoteTransfer->setPayment($paymentTransfer);

        $quoteTransfer
            ->setShippingAddress($shippingAddressTransfer)
            ->setBillingAddress($billingAddressTransfer);

        return $quoteTransfer;
    }
}
