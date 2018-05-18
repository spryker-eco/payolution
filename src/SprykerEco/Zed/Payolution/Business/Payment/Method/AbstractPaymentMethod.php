<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Payolution\Business\Payment\Method;

use Generated\Shared\Transfer\OrderTransfer;
use Orm\Zed\Payolution\Persistence\Map\SpyPaymentPayolutionTableMap;
use Orm\Zed\Payolution\Persistence\SpyPaymentPayolution;
use SprykerEco\Zed\Payolution\Business\Exception\GenderNotDefinedException;
use SprykerEco\Zed\Payolution\Dependency\Facade\PayolutionToMoneyInterface;
use SprykerEco\Zed\Payolution\PayolutionConfig;

abstract class AbstractPaymentMethod
{
    const PAYOLUTION_DATE_FORMAT = 'Y-m-d';

    /**
     * @var static string[]
     */
    protected static $genderMap = [
        SpyPaymentPayolutionTableMap::COL_GENDER_MALE => ApiConfig::SEX_MALE,
        SpyPaymentPayolutionTableMap::COL_GENDER_FEMALE => ApiConfig::SEX_FEMALE,
    ];

    /**
     * @var \SprykerEco\Zed\Payolution\PayolutionConfig
     */
    protected $config;

    /**
     * @var \SprykerEco\Zed\Payolution\Dependency\Facade\PayolutionToMoneyInterface
     */
    protected $moneyFacade;

    /**
     * @param \SprykerEco\Zed\Payolution\PayolutionConfig $config
     * @param \SprykerEco\Zed\Payolution\Dependency\Facade\PayolutionToMoneyInterface $moneyFacade
     */
    public function __construct(PayolutionConfig $config, PayolutionToMoneyInterface $moneyFacade)
    {
        $this->config = $config;
        $this->moneyFacade = $moneyFacade;
    }

    /**
     * @return \SprykerEco\Zed\Payolution\PayolutionConfig
     */
    protected function getConfig()
    {
        return $this->config;
    }

    /**
     * @return string
     */
    abstract public function getAccountBrand();

    /**
     * @return string
     */
    abstract protected function getTransactionChannel();

    /**
     * @return int
     */
    abstract public function getMinGrandTotal();

    /**
     * @return int
     */
    abstract public function getMaxGrandTotal();

    /**
     * @param int $grandTotal
     * @param string $currency
     * @param string|null $idOrder
     *
     * @return array
     */
    protected function getBaseTransactionRequest($grandTotal, $currency, $idOrder = null)
    {
        return [
            ApiConfig::ACCOUNT_BRAND => $this->getAccountBrand(),
            ApiConfig::TRANSACTION_MODE => $this->getConfig()->getTransactionMode(),
            ApiConfig::SECURITY_SENDER => $this->getConfig()->getTransactionSecuritySender(),
            ApiConfig::USER_LOGIN => $this->getConfig()->getTransactionUserLogin(),
            ApiConfig::USER_PWD => $this->getConfig()->getTransactionUserPassword(),
            ApiConfig::PRESENTATION_AMOUNT => $this->moneyFacade->convertIntegerToDecimal((int)$grandTotal),
            ApiConfig::PRESENTATION_USAGE => $idOrder,
            ApiConfig::PRESENTATION_CURRENCY => $currency,
            ApiConfig::IDENTIFICATION_TRANSACTIONID => $idOrder,
            ApiConfig::CRITERION_REQUEST_SYSTEM_VENDOR => ApiConfig::CRITERION_REQUEST_SYSTEM_VENDOR_VALUE,
            ApiConfig::CRITERION_REQUEST_SYSTEM_VERSION => ApiConfig::CRITERION_REQUEST_SYSTEM_VERSION_VALUE,
            ApiConfig::CRITERION_REQUEST_SYSTEM_TYPE => ApiConfig::CRITERION_REQUEST_SYSTEM_TYPE_VALUE,
            ApiConfig::CRITERION_MODULE_NAME => ApiConfig::CRITERION_MODULE_NAME_VALUE,
            ApiConfig::CRITERION_MODULE_VERSION => ApiConfig::CRITERION_MODULE_VERSION_VALUE,
            ApiConfig::CRITERION_WEBSHOP_URL => $this->getConfig()->getWebshopUrl(),
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Orm\Zed\Payolution\Persistence\SpyPaymentPayolution $paymentEntity
     * @param string $paymentCode
     * @param string $uniqueId
     *
     * @return array
     */
    protected function getBaseTransactionRequestForPayment(
        OrderTransfer $orderTransfer,
        SpyPaymentPayolution $paymentEntity,
        $paymentCode,
        $uniqueId
    ) {
        $requestData = $this->getBaseTransactionRequest(
            $this->getGrandTotal($orderTransfer),
            $paymentEntity->getCurrencyIso3Code(),
            $orderTransfer->getIdSalesOrder()
        );

        $this->addRequestData(
            $requestData,
            [
                ApiConfig::TRANSACTION_CHANNEL => $this->getTransactionChannel(),
                ApiConfig::PAYMENT_CODE => $paymentCode,
                ApiConfig::IDENTIFICATION_REFERENCEID => $uniqueId,
            ]
        );

        return $requestData;
    }

    /**
     * @param array $requestData
     * @param array $additionalData
     *
     * @return void
     */
    protected function addRequestData(&$requestData, $additionalData)
    {
        foreach ($additionalData as $fieldName => $value) {
            $requestData[$fieldName] = $value;
        }
    }

    /**
     * @param string $gender
     *
     * @throws \SprykerEco\Zed\Payolution\Business\Exception\GenderNotDefinedException
     *
     * @return string
     */
    protected function mapGender($gender)
    {
        if (!isset(self::$genderMap[$gender])) {
            throw new GenderNotDefinedException('The given gender is not defined.');
        }

        return self::$genderMap[$gender];
    }

    /**
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     *
     * @return string
     */
    protected function formatAddress($addressTransfer)
    {
        return trim(sprintf(
            '%s %s %s',
            $addressTransfer->getAddress1(),
            $addressTransfer->getAddress2(),
            $addressTransfer->getAddress3()
        ));
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return int
     */
    protected function getGrandTotal(OrderTransfer $orderTransfer)
    {
        if ($orderTransfer->getTotals()->getRefundTotal() > 0) {
            return $orderTransfer->getTotals()->getRefundTotal();
        }

        return $orderTransfer->getTotals()->getGrandTotal();
    }
}
