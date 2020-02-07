<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Payolution\Communication\Plugin\Oms\Command;

use Generated\Shared\Transfer\PayolutionTransactionResponseTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject;
use Spryker\Zed\Oms\Dependency\Plugin\Command\CommandByOrderInterface;
use SprykerEco\Shared\Payolution\PayolutionConfig;

/**
 * @method \SprykerEco\Zed\Payolution\Business\PayolutionFacade getFacade()
 * @method \SprykerEco\Zed\Payolution\Communication\PayolutionCommunicationFactory getFactory()
 */
class RefundPlugin extends AbstractPlugin implements CommandByOrderInterface
{
    /**
     * @api
     *
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject $data
     *
     * @return array
     */
    public function run(array $orderItems, SpySalesOrder $orderEntity, ReadOnlyArrayObject $data)
    {
        $omsEntityConverter = $this->getFactory()->createOmsEntityConverter($orderItems, $orderEntity);
        $orderTransfer = $omsEntityConverter->extractOrderTransfer($orderEntity);

        $refundTransfer = $this->getFactory()
            ->getRefundFacade()
            ->calculateRefund($orderItems, $orderEntity);

        $orderTransfer->getTotals()->setRefundTotal(
            $refundTransfer->getAmount()
        );

        $paymentEntity = $omsEntityConverter->extractPaymentEntity($orderEntity);

        $responseTransfer = $this->getFacade()
            ->refundPayment(
                $orderTransfer,
                $paymentEntity->getIdPaymentPayolution()
            );

        if ($this->isTransactionSuccessful($responseTransfer)) {
            $this->getFactory()
                ->getRefundFacade()
                ->saveRefund($refundTransfer);
        }

        return [];
    }

    /**
     * @param \Generated\Shared\Transfer\PayolutionTransactionResponseTransfer $transactionResponseTransfer
     *
     * @return bool
     */
    protected function isTransactionSuccessful(PayolutionTransactionResponseTransfer $transactionResponseTransfer)
    {
        if ($transactionResponseTransfer->getProcessingReasonCode() !== PayolutionConfig::REASON_CODE_SUCCESS) {
            return false;
        }
        if ($transactionResponseTransfer->getProcessingStatusCode() !== PayolutionConfig::STATUS_CODE_SUCCESS) {
            return false;
        }
        if ($transactionResponseTransfer->getPaymentCode() !== PayolutionConfig::PAYMENT_CODE_REFUND) {
            return false;
        }

        return true;
    }
}
