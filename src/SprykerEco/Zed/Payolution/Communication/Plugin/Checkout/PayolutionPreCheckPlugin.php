<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Payolution\Communication\Plugin\Checkout;

use Generated\Shared\Transfer\CheckoutErrorTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\PayolutionTransactionResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin as BaseAbstractPlugin;
use Spryker\Zed\Payment\Dependency\Plugin\Checkout\CheckoutPreCheckPluginInterface;
use SprykerEco\Shared\Payolution\PayolutionConfig;

/**
 * @method \SprykerEco\Zed\Payolution\Business\PayolutionFacade getFacade()
 */
class PayolutionPreCheckPlugin extends BaseAbstractPlugin implements CheckoutPreCheckPluginInterface
{
    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return void
     */
    public function execute(
        QuoteTransfer $quoteTransfer,
        CheckoutResponseTransfer $checkoutResponseTransfer
    ) {
        $payolutionTransactionResponseTransfer = $this->getFacade()->preCheckPayment($quoteTransfer);
        $this->checkForErrors($payolutionTransactionResponseTransfer, $checkoutResponseTransfer);
        $quoteTransfer->getPayment()->getPayolution()
            ->setPreCheckId($payolutionTransactionResponseTransfer->getIdentificationUniqueid());
    }

    /**
     * @param \Generated\Shared\Transfer\PayolutionTransactionResponseTransfer $payolutionTransactionResponseTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return void
     */
    protected function checkForErrors(
        PayolutionTransactionResponseTransfer $payolutionTransactionResponseTransfer,
        CheckoutResponseTransfer $checkoutResponseTransfer
    ) {
        if ($this->isResponseInvalid($payolutionTransactionResponseTransfer)) {
            $errorCode = (int)preg_replace('/[^\d]+/', '', $payolutionTransactionResponseTransfer->getProcessingCode());
            $error = new CheckoutErrorTransfer();
            $error
                ->setErrorCode($errorCode)
                ->setMessage($payolutionTransactionResponseTransfer->getProcessingReturn());
            $checkoutResponseTransfer->addError($error);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\PayolutionTransactionResponseTransfer $payolutionTransactionResponseTransfer
     *
     * @return bool
     */
    protected function isResponseInvalid(PayolutionTransactionResponseTransfer $payolutionTransactionResponseTransfer): bool
    {
        return $payolutionTransactionResponseTransfer->getProcessingReasonCode() !== PayolutionConfig::REASON_CODE_SUCCESS
            || $payolutionTransactionResponseTransfer->getProcessingStatusCode() !== PayolutionConfig::STATUS_CODE_SUCCESS
            || $payolutionTransactionResponseTransfer->getPaymentCode() !== PayolutionConfig::PAYMENT_CODE_PRE_CHECK;
    }
}
