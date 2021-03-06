<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Payolution\Business\Payment\Method\Invoice;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Orm\Zed\Payolution\Persistence\SpyPaymentPayolution;

interface InvoiceInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array
     */
    public function buildPreCheckRequest(QuoteTransfer $quoteTransfer);

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Orm\Zed\Payolution\Persistence\SpyPaymentPayolution $paymentEntity
     * @param array $orderItems
     *
     * @return array
     */
    public function buildPreAuthorizationRequest(OrderTransfer $orderTransfer, SpyPaymentPayolution $paymentEntity, array $orderItems);

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Orm\Zed\Payolution\Persistence\SpyPaymentPayolution $paymentEntity
     * @param string $uniqueId
     * @param array $orderItems
     *
     * @return array
     */
    public function buildReAuthorizationRequest(OrderTransfer $orderTransfer, SpyPaymentPayolution $paymentEntity, $uniqueId, array $orderItems);

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Orm\Zed\Payolution\Persistence\SpyPaymentPayolution $paymentEntity
     * @param string $uniqueId
     * @param array $orderItems
     *
     * @return array
     */
    public function buildRevertRequest(OrderTransfer $orderTransfer, SpyPaymentPayolution $paymentEntity, $uniqueId, array $orderItems);

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Orm\Zed\Payolution\Persistence\SpyPaymentPayolution $paymentEntity
     * @param string $uniqueId
     * @param array $orderItems
     *
     * @return array
     */
    public function buildCaptureRequest(OrderTransfer $orderTransfer, SpyPaymentPayolution $paymentEntity, $uniqueId, array $orderItems);

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Orm\Zed\Payolution\Persistence\SpyPaymentPayolution $paymentEntity
     * @param string $uniqueId
     *
     * @return array
     */
    public function buildRefundRequest(OrderTransfer $orderTransfer, SpyPaymentPayolution $paymentEntity, $uniqueId);

    /**
     * @return string
     */
    public function getAccountBrand();

    /**
     * @return int
     */
    public function getMinGrandTotal();

    /**
     * @return int
     */
    public function getMaxGrandTotal();
}
