<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Payolution\Communication\Controller;

use Generated\Shared\Transfer\PayolutionCalculationResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \Spryker\Zed\Payolution\Business\PayolutionFacade getFacade()
 */
class GatewayController extends AbstractGatewayController
{

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\PayolutionCalculationResponseTransfer
     */
    public function calculateInstallmentPaymentsAction(QuoteTransfer $quoteTransfer)
    {
        return $this->getFacade()->calculateInstallmentPayments($quoteTransfer);
    }

}