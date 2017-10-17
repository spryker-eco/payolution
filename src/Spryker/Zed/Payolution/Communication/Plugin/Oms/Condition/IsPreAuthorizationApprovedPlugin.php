<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Payolution\Communication\Plugin\Oms\Condition;

use Generated\Shared\Transfer\OrderTransfer;

/**
 * @method \Spryker\Zed\Payolution\Business\PayolutionFacade getFacade()
 */
class IsPreAuthorizationApprovedPlugin extends AbstractCheckPlugin
{

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    protected function callFacade(OrderTransfer $orderTransfer)
    {
        return $this->getFacade()->isPreAuthorizationApproved($orderTransfer);
    }

}
