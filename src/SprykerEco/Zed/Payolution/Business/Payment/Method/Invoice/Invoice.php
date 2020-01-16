<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Payolution\Business\Payment\Method\Invoice;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Orm\Zed\Payolution\Persistence\SpyPaymentPayolution;
use SprykerEco\Shared\Payolution\PayolutionConfig;
use SprykerEco\Zed\Payolution\Business\Payment\Method\AbstractPaymentMethod;
use SprykerEco\Zed\Payolution\Business\Payment\Method\ApiConfig;

class Invoice extends AbstractPaymentMethod implements InvoiceInterface
{
    /**
     * @return string
     */
    public function getAccountBrand()
    {
        return PayolutionConfig::BRAND_INVOICE;
    }

    /**
     * @return string
     */
    protected function getTransactionChannel()
    {
        return $this->getConfig()->getTransactionChannelInvoice();
    }

    /**
     * @return int
     */
    public function getMinGrandTotal()
    {
        return $this->getConfig()->getMinOrderGrandTotalInvoice();
    }

    /**
     * @return int
     */
    public function getMaxGrandTotal()
    {
        return $this->getConfig()->getMaxOrderGrandTotalInvoice();
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
            ]
        );

        return $requestData;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Orm\Zed\Payolution\Persistence\SpyPaymentPayolution $paymentEntity
     * @param array $orderItems
     *
     * @return array
     */
    public function buildPreAuthorizationRequest(OrderTransfer $orderTransfer, SpyPaymentPayolution $paymentEntity, array $orderItems)
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
            ]
        );

        return $requestData;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Orm\Zed\Payolution\Persistence\SpyPaymentPayolution $paymentEntity
     * @param string $uniqueId
     * @param array $orderItems
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
     * @param array $orderItems
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
     * @param array $orderItems
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
