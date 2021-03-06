<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Payolution\Business;

use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\PayolutionOmsOperationRequestTransfer;
use Generated\Shared\Transfer\PayolutionTransactionResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \SprykerEco\Zed\Payolution\Business\PayolutionBusinessFactory getFactory()
 */
class PayolutionFacade extends AbstractFacade implements PayolutionFacadeInterface
{
    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return void
     */
    public function saveOrderPayment(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponseTransfer)
    {
        $this
             ->getFactory()
             ->createOrderSaver()
             ->saveOrderPayment($quoteTransfer, $checkoutResponseTransfer);
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\PayolutionTransactionResponseTransfer
     */
    public function preCheckPayment(QuoteTransfer $quoteTransfer)
    {
        $payolutionResponseTransfer = $this
            ->getFactory()
            ->createPaymentTransactionHandler()
            ->preCheckPayment($quoteTransfer);

        return $payolutionResponseTransfer;
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param int $idPayment
     *
     * @return \Generated\Shared\Transfer\PayolutionTransactionResponseTransfer
     */
    public function preAuthorizePayment(OrderTransfer $orderTransfer, $idPayment)
    {
        return $this
            ->getFactory()
            ->createPaymentTransactionHandler()
            ->preAuthorizePayment($orderTransfer, $idPayment);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PayolutionOmsOperationRequestTransfer $payolutionOmsOperationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\PayolutionTransactionResponseTransfer
     */
    public function preAuthorizePartialPayment(PayolutionOmsOperationRequestTransfer $payolutionOmsOperationRequestTransfer): PayolutionTransactionResponseTransfer
    {
        return $this
            ->getFactory()
            ->createPaymentTransactionHandler()
            ->preAuthorizePayment(
                $payolutionOmsOperationRequestTransfer->getOrder(),
                $payolutionOmsOperationRequestTransfer->getIdPayment(),
                $payolutionOmsOperationRequestTransfer->getSelectedItems()
            );
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param int $idPayment
     *
     * @return \Generated\Shared\Transfer\PayolutionTransactionResponseTransfer
     */
    public function reAuthorizePayment(OrderTransfer $orderTransfer, $idPayment)
    {
        return $this
            ->getFactory()
            ->createPaymentTransactionHandler()
            ->reAuthorizePayment($orderTransfer, $idPayment);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PayolutionOmsOperationRequestTransfer $payolutionOmsOperationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\PayolutionTransactionResponseTransfer
     */
    public function reAuthorizePartialPayment(PayolutionOmsOperationRequestTransfer $payolutionOmsOperationRequestTransfer): PayolutionTransactionResponseTransfer
    {
        return $this
            ->getFactory()
            ->createPaymentTransactionHandler()
            ->reAuthorizePayment(
                $payolutionOmsOperationRequestTransfer->getOrder(),
                $payolutionOmsOperationRequestTransfer->getIdPayment(),
                $payolutionOmsOperationRequestTransfer->getSelectedItems()
            );
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param int $idPayment
     *
     * @return \Generated\Shared\Transfer\PayolutionTransactionResponseTransfer
     */
    public function revertPayment(OrderTransfer $orderTransfer, $idPayment)
    {
        return $this
            ->getFactory()
            ->createPaymentTransactionHandler()
            ->revertPayment($orderTransfer, $idPayment);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PayolutionOmsOperationRequestTransfer $payolutionOmsOperationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\PayolutionTransactionResponseTransfer
     */
    public function revertPartialPayment(PayolutionOmsOperationRequestTransfer $payolutionOmsOperationRequestTransfer): PayolutionTransactionResponseTransfer
    {
        return $this
            ->getFactory()
            ->createPaymentTransactionHandler()
            ->revertPayment(
                $payolutionOmsOperationRequestTransfer->getOrder(),
                $payolutionOmsOperationRequestTransfer->getIdPayment(),
                $payolutionOmsOperationRequestTransfer->getSelectedItems()
            );
    }


    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param int $idPayment
     *
     * @return \Generated\Shared\Transfer\PayolutionTransactionResponseTransfer
     */
    public function capturePayment(OrderTransfer $orderTransfer, $idPayment)
    {
        return $this
            ->getFactory()
            ->createPaymentTransactionHandler()
            ->capturePayment($orderTransfer, $idPayment);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PayolutionOmsOperationRequestTransfer $payolutionOmsOperationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\PayolutionTransactionResponseTransfer
     */
    public function capturePartialPayment(PayolutionOmsOperationRequestTransfer $payolutionOmsOperationRequestTransfer): PayolutionTransactionResponseTransfer
    {
        return $this
            ->getFactory()
            ->createPaymentTransactionHandler()
            ->capturePayment(
                $payolutionOmsOperationRequestTransfer->getOrder(),
                $payolutionOmsOperationRequestTransfer->getIdPayment(),
                $payolutionOmsOperationRequestTransfer->getSelectedItems()
            );
    }


    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param int $idPayment
     *
     * @return \Generated\Shared\Transfer\PayolutionTransactionResponseTransfer
     */
    public function refundPayment(OrderTransfer $orderTransfer, $idPayment)
    {
        return $this
            ->getFactory()
            ->createPaymentTransactionHandler()
            ->refundPayment($orderTransfer, $idPayment);
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\PayolutionCalculationResponseTransfer
     */
    public function calculateInstallmentPayments(QuoteTransfer $quoteTransfer)
    {
        $payolutionResponseTransfer = $this
            ->getFactory()
            ->createPaymentCalculationHandler()
            ->calculateInstallmentPayments($quoteTransfer);

        return $payolutionResponseTransfer;
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isPreAuthorizationApproved(OrderTransfer $orderTransfer)
    {
        return $this
            ->getFactory()
            ->createTransactionStatusLog()
            ->isPreAuthorizationApproved($orderTransfer);
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isReAuthorizationApproved(OrderTransfer $orderTransfer)
    {
        return $this
            ->getFactory()
            ->createTransactionStatusLog()
            ->isReAuthorizationApproved($orderTransfer);
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isReversalApproved(OrderTransfer $orderTransfer)
    {
        return $this
            ->getFactory()
            ->createTransactionStatusLog()
            ->isReversalApproved($orderTransfer);
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isCaptureApproved(OrderTransfer $orderTransfer)
    {
        return $this
            ->getFactory()
            ->createTransactionStatusLog()
            ->isCaptureApproved($orderTransfer);
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isRefundApproved(OrderTransfer $orderTransfer)
    {
        return $this
            ->getFactory()
            ->createTransactionStatusLog()
            ->isRefundApproved($orderTransfer);
    }
}
