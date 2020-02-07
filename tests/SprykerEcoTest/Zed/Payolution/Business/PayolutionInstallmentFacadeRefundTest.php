<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Payolution\Business;

use Generated\Shared\Transfer\PayolutionTransactionResponseTransfer;
use Orm\Zed\Payolution\Persistence\Map\SpyPaymentPayolutionTableMap;
use Orm\Zed\Payolution\Persistence\SpyPaymentPayolution;
use SprykerEco\Shared\Payolution\PayolutionConfig;
use SprykerEco\Zed\Payolution\Business\Payment\Method\ApiConfig;
use SprykerEcoTest\Zed\Payolution\Business\Api\Adapter\Http\CaptureAdapterMock;
use SprykerEcoTest\Zed\Payolution\Business\Api\Adapter\Http\PreAuthorizationAdapterMock;
use SprykerEcoTest\Zed\Payolution\Business\Api\Adapter\Http\RefundAdapterMock;

/**
 * Auto-generated group annotations
 * @group SprykerEcoTest
 * @group Zed
 * @group Payolution
 * @group Business
 * @group Facade
 * @group PayolutionInstallmentFacadeRefundTest
 * Add your own group annotations below this line
 */
class PayolutionInstallmentFacadeRefundTest extends PayolutionFacadeRefundTest
{
    /**
     * @return void
     */
    protected function setUpPaymentTestData()
    {
        $this->paymentEntity = (new SpyPaymentPayolution())
            ->setFkSalesOrder($this->getOrderEntity()->getIdSalesOrder())
            ->setAccountBrand(PayolutionConfig::BRAND_INSTALLMENT)
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
}
