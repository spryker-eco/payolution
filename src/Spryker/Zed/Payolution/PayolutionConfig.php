<?php

/**
 * This file is part of the Spryker Platform.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Spryker\Zed\Payolution;

use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\Payolution\PayolutionConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class PayolutionConfig extends AbstractBundleConfig
{

    /**
     * @return string
     */
    public function getTransactionGatewayUrl()
    {
        return $this->get(PayolutionConstants::TRANSACTION_GATEWAY_URL);
    }

    /**
     * @return string
     */
    public function getCalculationGatewayUrl()
    {
        return $this->get(PayolutionConstants::CALCULATION_GATEWAY_URL);
    }

    /**
     * @return string
     */
    public function getTransactionSecuritySender()
    {
        return $this->get(PayolutionConstants::TRANSACTION_SECURITY_SENDER);
    }

    /**
     * @return string
     */
    public function getTransactionUserLogin()
    {
        return $this->get(PayolutionConstants::TRANSACTION_USER_LOGIN);
    }

    /**
     * @return string
     */
    public function getTransactionUserPassword()
    {
        return $this->get(PayolutionConstants::TRANSACTION_USER_PASSWORD);
    }

    /**
     * @return string
     */
    public function getCalculationSender()
    {
        return $this->get(PayolutionConstants::CALCULATION_SENDER);
    }

    /**
     * @return string
     */
    public function getCalculationUserLogin()
    {
        return $this->get(PayolutionConstants::CALCULATION_USER_LOGIN);
    }

    /**
     * @return string
     */
    public function getCalculationUserPassword()
    {
        return $this->get(PayolutionConstants::CALCULATION_USER_PASSWORD);
    }

    /**
     * @return string
     */
    public function getTransactionMode()
    {
        return $this->get(PayolutionConstants::TRANSACTION_MODE);
    }

    /**
     * @return string
     */
    public function getCalculationMode()
    {
        return $this->get(PayolutionConstants::CALCULATION_MODE);
    }

    /**
     * @return string
     */
    public function getTransactionChannelInvoice()
    {
        return $this->get(PayolutionConstants::TRANSACTION_CHANNEL_INVOICE);
    }

    /**
     * @return string
     */
    public function getTransactionChannelInstallment()
    {
        return $this->get(PayolutionConstants::TRANSACTION_CHANNEL_INSTALLMENT);
    }

    /**
     * @return string
     */
    public function getTransactionChannelPreCheck()
    {
        return $this->get(PayolutionConstants::TRANSACTION_CHANNEL_PRE_CHECK);
    }

    /**
     * @return string
     */
    public function getCalculationChannel()
    {
        return $this->get(PayolutionConstants::CALCULATION_CHANNEL);
    }

    /**
     * @return int
     */
    public function getMinOrderGrandTotalInvoice()
    {
        return $this->get(PayolutionConstants::MIN_ORDER_GRAND_TOTAL_INVOICE);
    }

    /**
     * @return int
     */
    public function getMaxOrderGrandTotalInvoice()
    {
        return $this->get(PayolutionConstants::MAX_ORDER_GRAND_TOTAL_INVOICE);
    }

    /**
     * @return int
     */
    public function getMinOrderGrandTotalInstallment()
    {
        return $this->get(PayolutionConstants::MIN_ORDER_GRAND_TOTAL_INSTALLMENT);
    }

    /**
     * @return int
     */
    public function getMaxOrderGrandTotalInstallment()
    {
        return $this->get(PayolutionConstants::MAX_ORDER_GRAND_TOTAL_INSTALLMENT);
    }

    /**
     * @return string
     */
    public function getPayolutionBccEmail()
    {
        return $this->get(PayolutionConstants::PAYOLUTION_BCC_EMAIL);
    }

    /**
     * @return string
     */
    public function getEmailFromName()
    {
        return $this->get(PayolutionConstants::EMAIL_FROM_NAME);
    }

    /**
     * @return string
     */
    public function getEmailFromAddress()
    {
        return $this->get(PayolutionConstants::EMAIL_FROM_ADDRESS);
    }

    /**
     * @return string
     */
    public function getEmailTemplateName()
    {
        return $this->get(PayolutionConstants::EMAIL_TEMPLATE_NAME);
    }

    /**
     * @return string
     */
    public function getEmailSubject()
    {
        return $this->get(PayolutionConstants::EMAIL_SUBJECT);
    }

    /**
     * @return string
     */
    public function getWebshopUrl()
    {
        return $this->get(ApplicationConstants::HOST_YVES);
    }

}
