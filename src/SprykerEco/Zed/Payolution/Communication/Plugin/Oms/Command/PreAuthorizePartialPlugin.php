<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Payolution\Communication\Plugin\Oms\Command;

use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject;
use Spryker\Zed\Oms\Dependency\Plugin\Command\CommandByOrderInterface;

/**
 * @method \SprykerEco\Zed\Payolution\Business\PayolutionFacade getFacade()
 * @method \SprykerEco\Zed\Payolution\Communication\PayolutionCommunicationFactory getFactory()
 */
class PreAuthorizePartialPlugin extends AbstractPlugin implements CommandByOrderInterface
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

        $this->getFacade()->preAuthorizePayment(
            $omsEntityConverter->extractOrderTransfer($orderEntity),
            $omsEntityConverter->extractPaymentEntity($orderEntity)->getIdPaymentPayolution(),
            $omsEntityConverter->extractPartialOrderItems($orderItems, $orderEntity)
        );

        return [];
    }
}
