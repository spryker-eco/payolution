<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Payolution\Business\Log;

use Generated\Shared\Transfer\OrderTransfer;
use SprykerEco\Zed\Payolution\Business\Payment\Method\ApiConstants;
use SprykerEco\Zed\Payolution\Persistence\PayolutionQueryContainerInterface;

class TransactionStatusLog implements TransactionStatusLogInterface
{
    /**
     * @var \SprykerEco\Zed\Payolution\Persistence\PayolutionQueryContainerInterface
     */
    private $queryContainer;

    /**
     * @param \SprykerEco\Zed\Payolution\Persistence\PayolutionQueryContainerInterface $queryContainer
     */
    public function __construct(PayolutionQueryContainerInterface $queryContainer)
    {
        $this->queryContainer = $queryContainer;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isPreAuthorizationApproved(OrderTransfer $orderTransfer)
    {
        return $this->hasTransactionLogStatus(
            $orderTransfer,
            ApiConstants::PAYMENT_CODE_PRE_AUTHORIZATION,
            ApiConstants::STATUS_REASON_CODE_SUCCESS
        );
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isReAuthorizationApproved(OrderTransfer $orderTransfer)
    {
        return $this->hasTransactionLogStatus(
            $orderTransfer,
            ApiConstants::PAYMENT_CODE_RE_AUTHORIZATION,
            ApiConstants::STATUS_REASON_CODE_SUCCESS
        );
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isReversalApproved(OrderTransfer $orderTransfer)
    {
        return $this->hasTransactionLogStatus(
            $orderTransfer,
            ApiConstants::PAYMENT_CODE_REVERSAL,
            ApiConstants::STATUS_REASON_CODE_SUCCESS
        );
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isCaptureApproved(OrderTransfer $orderTransfer)
    {
        return $this->hasTransactionLogStatus(
            $orderTransfer,
            ApiConstants::PAYMENT_CODE_CAPTURE,
            ApiConstants::STATUS_REASON_CODE_SUCCESS
        );
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isRefundApproved(OrderTransfer $orderTransfer)
    {
        return $this->hasTransactionLogStatus(
            $orderTransfer,
            ApiConstants::PAYMENT_CODE_REFUND,
            ApiConstants::STATUS_REASON_CODE_SUCCESS
        );
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param string $paymentCode
     * @param string $expectedStatusReasonCode
     *
     * @return bool
     */
    private function hasTransactionLogStatus(OrderTransfer $orderTransfer, $paymentCode, $expectedStatusReasonCode)
    {
        $idSalesOrder = $orderTransfer->getIdSalesOrder();

        $logEntity = $this
            ->queryContainer
            ->queryTransactionStatusLogBySalesOrderIdAndPaymentCodeLatestFirst(
                $idSalesOrder,
                $paymentCode
            )
            ->findOne();

        if (!$logEntity) {
            return false;
        }

        $expectedProcessingCode = $paymentCode . '.' . $expectedStatusReasonCode;

        return ($expectedProcessingCode === $logEntity->getProcessingCode());
    }
}
