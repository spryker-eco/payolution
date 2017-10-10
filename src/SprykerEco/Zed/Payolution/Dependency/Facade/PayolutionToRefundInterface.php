<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Payolution\Dependency\Facade;

use Generated\Shared\Transfer\RefundTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;

interface PayolutionToRefundInterface
{

    /**
     * @param array $salesOrderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $salesOrderEntity
     *
     * @return \Generated\Shared\Transfer\RefundTransfer
     */
    public function calculateRefund(array $salesOrderItems, SpySalesOrder $salesOrderEntity);

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return bool
     */
    public function saveRefund(RefundTransfer $refundTransfer);

}
