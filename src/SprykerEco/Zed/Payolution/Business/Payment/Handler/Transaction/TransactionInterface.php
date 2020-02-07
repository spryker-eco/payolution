<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Payolution\Business\Payment\Handler\Transaction;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface TransactionInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\PayolutionTransactionResponseTransfer
     */
    public function preCheckPayment(QuoteTransfer $quoteTransfer);

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param int $idPayment
     * @param array $orderItems
     *
     * @return \Generated\Shared\Transfer\PayolutionTransactionResponseTransfer
     */
    public function preAuthorizePayment(OrderTransfer $orderTransfer, $idPayment, array $orderItems = []);

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param int $idPayment
     * @param array $orderItems
     *
     * @return \Generated\Shared\Transfer\PayolutionTransactionResponseTransfer
     */
    public function reAuthorizePayment(OrderTransfer $orderTransfer, $idPayment, array $orderItems = []);

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param int $idPayment
     * @param array $orderItems
     *
     * @return \Generated\Shared\Transfer\PayolutionTransactionResponseTransfer
     */
    public function revertPayment(OrderTransfer $orderTransfer, $idPayment, array $orderItems = []);

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param int $idPayment
     * @param array $orderItems
     *
     * @return \Generated\Shared\Transfer\PayolutionTransactionResponseTransfer
     */
    public function capturePayment(OrderTransfer $orderTransfer, $idPayment, array $orderItems = []);

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param int $idPayment
     *
     * @return \Generated\Shared\Transfer\PayolutionTransactionResponseTransfer
     */
    public function refundPayment(OrderTransfer $orderTransfer, $idPayment);
}
