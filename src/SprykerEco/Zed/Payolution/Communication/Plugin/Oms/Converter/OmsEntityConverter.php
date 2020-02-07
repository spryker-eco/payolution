<?php

namespace SprykerEco\Zed\Payolution\Communication\Plugin\Oms\Converter;

use ArrayObject;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\PayolutionOmsOperationRequestTransfer;
use Generated\Shared\Transfer\PayolutionPaymentTransfer;
use Orm\Zed\Payolution\Persistence\SpyPaymentPayolution;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use SprykerEco\Zed\Payolution\Dependency\Facade\PayolutionToSalesInterface;

class OmsEntityConverter implements OmsEntityConverterInterface
{
    /**
     * @var \SprykerEco\Zed\Payolution\Dependency\Facade\PayolutionToSalesInterface $salesFacade
     */
    protected $salesFacade;

    /**
     * @param array $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \SprykerEco\Zed\Payolution\Dependency\Facade\PayolutionToSalesInterface $salesFacade
     */
    public function __construct(PayolutionToSalesInterface $salesFacade)
    {
        $this->salesFacade = $salesFacade;
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     *
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrderItem[]|ArrayObject
     */
    public function extractPartialOrderItems(array $orderItems, SpySalesOrder $orderEntity)
    {
        if (count($orderItems) < count($orderEntity->getItems())) {
            $orderItemIds = [];

            foreach ($orderItems as $orderItem) {
                $orderItemIds[]= $orderItem->getIdSalesOrderItem();
            }

            $orderTransfer = $this->extractOrderTransfer($orderEntity);

            $orderItemTransfers = new ArrayObject();
            /** @var \Generated\Shared\Transfer\ItemTransfer $itemTransfer */
            foreach ($orderTransfer->getItems() as $itemTransfer) {
                if (in_array($itemTransfer->getIdSalesOrderItem(), $orderItemIds)) {
                    $orderItemTransfers->append($itemTransfer);
                }
            }

            return $orderItemTransfers;
        }

        return new ArrayObject();
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function extractOrderTransfer(SpySalesOrder $orderEntity): OrderTransfer
    {
        return $this->salesFacade->getOrderByIdSalesOrder($orderEntity->getIdSalesOrder());
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     *
     * @return \Orm\Zed\Payolution\Persistence\SpyPaymentPayolution
     */
    public function extractPaymentEntity(SpySalesOrder $orderEntity): SpyPaymentPayolution
    {
        return $orderEntity->getSpyPaymentPayolutions()->getFirst();
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     *
     * @return \Generated\Shared\Transfer\PayolutionPaymentTransfer
     */
    public function extractPaymentTransfer(SpySalesOrder $orderEntity): PayolutionPaymentTransfer
    {
        return $this->extractOrderTransfer($orderEntity)->getPayolutionPayment();
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     *
     * @return \Generated\Shared\Transfer\PayolutionOmsOperationRequestTransfer
     */
    public function extractPayolutionOmsOperationRequest(array $orderItems, SpySalesOrder $orderEntity): PayolutionOmsOperationRequestTransfer
    {
        $payolutionOmsOperationRequestTransfer = new PayolutionOmsOperationRequestTransfer();
        $orderTransfer = $this->extractOrderTransfer($orderEntity);

        $payolutionOmsOperationRequestTransfer->setIdPayment($this->extractPaymentEntity($orderEntity)->getIdPaymentPayolution());
        $payolutionOmsOperationRequestTransfer->setOrder($orderTransfer);
        $payolutionOmsOperationRequestTransfer->setSelectedItems($this->extractPartialOrderItems($orderItems, $orderEntity));

        return $payolutionOmsOperationRequestTransfer;
    }
}
