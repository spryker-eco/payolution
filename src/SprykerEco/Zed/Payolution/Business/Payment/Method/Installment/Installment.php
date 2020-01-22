<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Payolution\Business\Payment\Method\Installment;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Orm\Zed\Payolution\Persistence\SpyPaymentPayolution;
use Spryker\Shared\Kernel\Store;
use SprykerEco\Shared\Payolution\PayolutionConfig;
use SprykerEco\Zed\Payolution\Business\Payment\Method\AbstractPaymentMethod;
use SprykerEco\Zed\Payolution\Business\Payment\Method\ApiConfig;

class Installment extends AbstractPaymentMethod implements InstallmentInterface
{
    /**
     * @return string
     */
    public function getAccountBrand()
    {
        return PayolutionConfig::BRAND_INSTALLMENT;
    }

    /**
     * @return string
     */
    protected function getTransactionChannel()
    {
        return $this->getConfig()->getTransactionChannelInstallment();
    }

    /**
     * @return int
     */
    public function getMinGrandTotal()
    {
        return $this->getConfig()->getMinOrderGrandTotalInstallment();
    }

    /**
     * @return int
     */
    public function getMaxGrandTotal()
    {
        return $this->getConfig()->getMaxOrderGrandTotalInstallment();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array
     */
    public function buildCalculationRequest(QuoteTransfer $quoteTransfer)
    {
        return [
            ApiConfig::CALCULATION_XML_ELEMENT_NAME => ApiConfig::CALCULATION_XML_REQUEST_ELEMENT,
            ApiConfig::CALCULATION_XML_ELEMENT_ATTRIBUTES => [
                ApiConfig::CALCULATION_XML_REQUEST_VERSION_ATTRIBUTE => ApiConfig::CALCULATION_REQUEST_VERSION,
            ],
            [
                ApiConfig::CALCULATION_XML_ELEMENT_NAME => ApiConfig::CALCULATION_XML_SENDER_ELEMENT,
                ApiConfig::CALCULATION_XML_ELEMENT_VALUE => $this->getConfig()->getCalculationSender(),
            ],
            [
                ApiConfig::CALCULATION_XML_ELEMENT_NAME => ApiConfig::CALCULATION_XML_TRANSACTION_ELEMENT,
                ApiConfig::CALCULATION_XML_ELEMENT_ATTRIBUTES => [
                    ApiConfig::CALCULATION_XML_TRANSACTION_MODE_ATTRIBUTE => $this->getConfig()->getCalculationMode(),
                    ApiConfig::CALCULATION_XML_TRANSACTION_CHANNEL_ATTRIBUTE => $this->getConfig()->getCalculationChannel(),
                ],
                [
                    ApiConfig::CALCULATION_XML_ELEMENT_NAME => ApiConfig::CALCULATION_XML_IDENTIFICATION_ELEMENT,
                    [
                        ApiConfig::CALCULATION_XML_ELEMENT_NAME => ApiConfig::CALCULATION_XML_TRANSACTIONID_ELEMENT,
                        ApiConfig::CALCULATION_XML_ELEMENT_VALUE => null,
                    ],
                ],
                [
                    ApiConfig::CALCULATION_XML_ELEMENT_NAME => ApiConfig::CALCULATION_XML_PAYMENT_ELEMENT,
                    [
                        ApiConfig::CALCULATION_XML_ELEMENT_NAME => ApiConfig::CALCULATION_XML_OPERATION_TYPE_ELEMENT,
                        ApiConfig::CALCULATION_XML_ELEMENT_VALUE => ApiConfig::CALCULATION_OPERATION_TYPE,
                    ],
                    [
                        ApiConfig::CALCULATION_XML_ELEMENT_NAME => ApiConfig::CALCULATION_XML_PAYMENT_TYPE_ELEMENT,
                        ApiConfig::CALCULATION_XML_ELEMENT_VALUE => ApiConfig::CALCULATION_PAYMENT_TYPE,
                    ],
                    [
                        ApiConfig::CALCULATION_XML_ELEMENT_NAME => ApiConfig::CALCULATION_XML_PRESENTATION_ELEMENT,
                        [
                            ApiConfig::CALCULATION_XML_ELEMENT_NAME => ApiConfig::CALCULATION_XML_CURRENCY_ELEMENT,
                            ApiConfig::CALCULATION_XML_ELEMENT_VALUE => Store::getInstance()->getCurrencyIsoCode(),
                        ],
                        [
                            ApiConfig::CALCULATION_XML_ELEMENT_NAME => ApiConfig::CALCULATION_XML_USAGE_ELEMENT,
                            ApiConfig::CALCULATION_XML_ELEMENT_VALUE => null,
                        ],
                        [
                            ApiConfig::CALCULATION_XML_ELEMENT_NAME => ApiConfig::CALCULATION_XML_AMOUNT_ELEMENT,
                            ApiConfig::CALCULATION_XML_ELEMENT_VALUE => $this->moneyFacade->convertIntegerToDecimal($quoteTransfer->getTotals()->getGrandTotal()),
                        ],
                        [
                            ApiConfig::CALCULATION_XML_ELEMENT_NAME => ApiConfig::CALCULATION_XML_VAT_ELEMENT,
                            ApiConfig::CALCULATION_XML_ELEMENT_VALUE => null,
                        ],
                    ],
                ],
                [
                    ApiConfig::CALCULATION_XML_ELEMENT_NAME => ApiConfig::CALCULATION_XML_ANALYSIS_ELEMENT,
                    [
                        ApiConfig::CALCULATION_XML_ELEMENT_NAME => ApiConfig::CALCULATION_XML_CRITERION_ELEMENT,
                        ApiConfig::CALCULATION_XML_ELEMENT_ATTRIBUTES => [
                            ApiConfig::CALCULATION_XML_ELEMENT_NAME => ApiConfig::CALCULATION_TARGET_COUNTRY,
                        ],
                        ApiConfig::CALCULATION_XML_ELEMENT_VALUE => $quoteTransfer->getBillingAddress()->getIso2Code(),
                    ],
                ],

            ],
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array
     */
    public function buildPreCheckRequest(QuoteTransfer $quoteTransfer)
    {
        $payolutionTransfer = $quoteTransfer->getPayment()->getPayolution();
        $addressTransfer = $payolutionTransfer->getAddress();

        $requestData = $this->getBaseTransactionRequest(
            $quoteTransfer->getTotals()->getGrandTotal(),
            $payolutionTransfer->getCurrencyIso3Code()
        );
        $this->addRequestData(
            $requestData,
            [
                ApiConfig::PAYMENT_CODE => ApiConfig::PAYMENT_CODE_PRE_CHECK,
                ApiConfig::TRANSACTION_CHANNEL => $this->config->getTransactionChannelPreCheck(),
                ApiConfig::NAME_GIVEN => $addressTransfer->getFirstName(),
                ApiConfig::NAME_FAMILY => $addressTransfer->getLastName(),
                ApiConfig::NAME_TITLE => $addressTransfer->getSalutation(),
                ApiConfig::NAME_SEX => $this->mapGender($payolutionTransfer->getGender()),
                ApiConfig::NAME_BIRTHDATE => $payolutionTransfer->getDateOfBirth(),
                ApiConfig::ADDRESS_STREET => $this->formatAddress($addressTransfer),
                ApiConfig::ADDRESS_ZIP => $addressTransfer->getZipCode(),
                ApiConfig::ADDRESS_CITY => $addressTransfer->getCity(),
                ApiConfig::ADDRESS_COUNTRY => $addressTransfer->getIso2Code(),
                ApiConfig::CONTACT_EMAIL => $payolutionTransfer->getEmail(),
                ApiConfig::CONTACT_PHONE => $addressTransfer->getPhone(),
                ApiConfig::CONTACT_MOBILE => $addressTransfer->getCellPhone(),
                ApiConfig::CONTACT_IP => $payolutionTransfer->getClientIp(),
                ApiConfig::CRITERION_PRE_CHECK => 'TRUE',
                ApiConfig::CRITERION_CUSTOMER_LANGUAGE => $payolutionTransfer->getLanguageIso2Code(),
                ApiConfig::CRITERION_CALCULATION_ID => $payolutionTransfer->getInstallmentCalculationId(),
                ApiConfig::CRITERION_INSTALLMENT_AMOUNT => $this->moneyFacade->convertIntegerToDecimal((int)$payolutionTransfer->getInstallmentAmount()),
                ApiConfig::CRITERION_DURATION => $payolutionTransfer->getInstallmentDuration(),
                ApiConfig::CRITERION_ACCOUNT_HOLDER => $payolutionTransfer->getBankAccountHolder(),
                ApiConfig::CRITERION_ACCOUNT_BIC => $payolutionTransfer->getBankAccountBic(),
                ApiConfig::CRITERION_ACCOUNT_IBAN => $payolutionTransfer->getBankAccountIban(),
                ApiConfig::CRITERION_ACCOUNT_COUNTRY => $addressTransfer->getIso2Code(),
            ]
        );

        return $requestData;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Orm\Zed\Payolution\Persistence\SpyPaymentPayolution $paymentEntity
     * @param \Generated\Shared\Transfer\ItemTransfer[] $orderItems
     *
     * @return array
     */
    public function buildPreAuthorizationRequest(OrderTransfer $orderTransfer, SpyPaymentPayolution $paymentEntity, $orderItems)
    {
        $requestData = $this->getBaseTransactionRequestForPayment(
            $orderTransfer,
            $paymentEntity,
            ApiConfig::PAYMENT_CODE_PRE_AUTHORIZATION,
            null,
            $orderItems
        );
        $this->addRequestData(
            $requestData,
            [
                ApiConfig::NAME_GIVEN => $paymentEntity->getFirstName(),
                ApiConfig::NAME_FAMILY => $paymentEntity->getLastName(),
                ApiConfig::NAME_TITLE => $paymentEntity->getSalutation(),
                ApiConfig::NAME_SEX => $this->mapGender($paymentEntity->getGender()),
                ApiConfig::NAME_BIRTHDATE => $paymentEntity->getDateOfBirth(self::PAYOLUTION_DATE_FORMAT),
                ApiConfig::ADDRESS_STREET => $paymentEntity->getStreet(),
                ApiConfig::ADDRESS_ZIP => $paymentEntity->getZipCode(),
                ApiConfig::ADDRESS_CITY => $paymentEntity->getCity(),
                ApiConfig::ADDRESS_COUNTRY => $paymentEntity->getCountryIso2Code(),
                ApiConfig::CONTACT_EMAIL => $paymentEntity->getEmail(),
                ApiConfig::CONTACT_PHONE => $paymentEntity->getPhone(),
                ApiConfig::CONTACT_MOBILE => $paymentEntity->getCellPhone(),
                ApiConfig::CONTACT_IP => $paymentEntity->getClientIp(),
                ApiConfig::IDENTIFICATION_SHOPPERID => $paymentEntity->getSpySalesOrder()->getCustomerReference(),
                ApiConfig::CRITERION_PRE_CHECK_ID => $paymentEntity->getPreCheckId(),
                ApiConfig::CRITERION_CUSTOMER_LANGUAGE => $paymentEntity->getLanguageIso2Code(),
                ApiConfig::CRITERION_CALCULATION_ID => $paymentEntity->getInstallmentCalculationId(),
                ApiConfig::CRITERION_INSTALLMENT_AMOUNT => $this->moneyFacade->convertIntegerToDecimal((int)$paymentEntity->getInstallmentAmount()),
                ApiConfig::CRITERION_DURATION => $paymentEntity->getInstallmentDuration(),
                ApiConfig::CRITERION_ACCOUNT_HOLDER => $paymentEntity->getBankAccountHolder(),
                ApiConfig::CRITERION_ACCOUNT_BIC => $paymentEntity->getBankAccountBic(),
                ApiConfig::CRITERION_ACCOUNT_IBAN => $paymentEntity->getBankAccountIban(),
                ApiConfig::CRITERION_ACCOUNT_COUNTRY => $paymentEntity->getCountryIso2Code(),
            ]
        );

        return $requestData;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Orm\Zed\Payolution\Persistence\SpyPaymentPayolution $paymentEntity
     * @param string $uniqueId
     * @param \Generated\Shared\Transfer\ItemTransfer[] $orderItems
     *
     * @return array
     */
    public function buildReAuthorizationRequest(
        OrderTransfer $orderTransfer,
        SpyPaymentPayolution $paymentEntity,
        $uniqueId,
        array $orderItems
    ) {
        return $this->getBaseTransactionRequestForPayment(
            $orderTransfer,
            $paymentEntity,
            ApiConfig::PAYMENT_CODE_RE_AUTHORIZATION,
            $uniqueId,
            $orderItems
        );
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Orm\Zed\Payolution\Persistence\SpyPaymentPayolution $paymentEntity
     * @param string $uniqueId
     * @param \Generated\Shared\Transfer\ItemTransfer[] $orderItems
     *
     * @return array
     */
    public function buildRevertRequest(
        OrderTransfer $orderTransfer,
        SpyPaymentPayolution $paymentEntity,
        $uniqueId,
        array $orderItems
    ) {
        return $this->getBaseTransactionRequestForPayment(
            $orderTransfer,
            $paymentEntity,
            ApiConfig::PAYMENT_CODE_REVERSAL,
            $uniqueId,
            $orderItems
        );
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Orm\Zed\Payolution\Persistence\SpyPaymentPayolution $paymentEntity
     * @param string $uniqueId
     * @param \Generated\Shared\Transfer\ItemTransfer[] $orderItems
     *
     * @return array
     */
    public function buildCaptureRequest(
        OrderTransfer $orderTransfer,
        SpyPaymentPayolution $paymentEntity,
        $uniqueId,
        array $orderItems
    ) {
        return $this->getBaseTransactionRequestForPayment(
            $orderTransfer,
            $paymentEntity,
            ApiConfig::PAYMENT_CODE_CAPTURE,
            $uniqueId,
            $orderItems
        );
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Orm\Zed\Payolution\Persistence\SpyPaymentPayolution $paymentEntity
     * @param string $uniqueId
     *
     * @return array
     */
    public function buildRefundRequest(
        OrderTransfer $orderTransfer,
        SpyPaymentPayolution $paymentEntity,
        $uniqueId
    ) {
        return $this->getBaseTransactionRequestForPayment(
            $orderTransfer,
            $paymentEntity,
            ApiConfig::PAYMENT_CODE_REFUND,
            $uniqueId,
            []
        );
    }
}
