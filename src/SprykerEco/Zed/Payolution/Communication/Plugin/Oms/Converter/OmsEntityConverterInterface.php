<?php

namespace SprykerEco\Zed\Payolution\Communication\Plugin\Oms\Converter;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\PayolutionOmsOperationRequestTransfer;
use Generated\Shared\Transfer\PayolutionPaymentTransfer;
use Orm\Zed\Payolution\Persistence\SpyPaymentPayolution;
use Orm\Zed\Sales\Persistence\SpySalesOrder;

interface OmsEntityConverterInterface
{
    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     *
     * @return \int[]
     */
    public function extractPartialOrderItems(array $orderItems, SpySalesOrder $orderEntity);

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function extractOrderTransfer(SpySalesOrder $orderEntity): OrderTransfer;

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     *
     * @return \Orm\Zed\Payolution\Persistence\SpyPaymentPayolution
     */
    public function extractPaymentEntity(SpySalesOrder $orderEntity): SpyPaymentPayolution;

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     *
     * @return \Generated\Shared\Transfer\PayolutionPaymentTransfer
     */
    public function extractPaymentTransfer(SpySalesOrder $orderEntity): PayolutionPaymentTransfer;

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     *
     * @return \Generated\Shared\Transfer\PayolutionOmsOperationRequestTransfer
     */
    public function extractPayolutionOmsOperationRequest(array $orderItems, SpySalesOrder $orderEntity): PayolutionOmsOperationRequestTransfer;
}
