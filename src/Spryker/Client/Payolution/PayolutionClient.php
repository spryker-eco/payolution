<?php

/**
 * This file is part of the Spryker Platform.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Spryker\Client\Payolution;

use Generated\Shared\Transfer\PayolutionCalculationResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Spryker\Client\Payolution\PayolutionFactory getFactory()
 */
class PayolutionClient extends AbstractClient implements PayolutionClientInterface
{

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\PayolutionCalculationResponseTransfer
     */
    public function calculateInstallmentPayments(QuoteTransfer $quoteTransfer)
    {
        return $this
            ->getFactory()
            ->createPayolutionStub()
            ->calculateInstallmentPayments($quoteTransfer);
    }

    /**
     * @return \Spryker\Client\Payolution\Session\PayolutionSession
     */
    protected function getSession()
    {
        return $this->getFactory()->createPayolutionSession();
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\PayolutionCalculationResponseTransfer $payolutionCalculationResponseTransfer
     *
     * @return \Generated\Shared\Transfer\PayolutionCalculationResponseTransfer
     */
    public function storeInstallmentPaymentsInSession(PayolutionCalculationResponseTransfer $payolutionCalculationResponseTransfer)
    {
        $this->getSession()->setInstallmentPayments($payolutionCalculationResponseTransfer);

        return $payolutionCalculationResponseTransfer;
    }

    /**
     * @api
     *
     * @return bool
     */
    public function hasInstallmentPaymentsInSession()
    {
        return $this->getSession()->hasInstallmentPayments();
    }

    /**
     * @api
     *
     * @return \Generated\Shared\Transfer\PayolutionCalculationResponseTransfer
     */
    public function getInstallmentPaymentsFromSession()
    {
        return $this->getSession()->getInstallmentPayments();
    }

    /**
     * @api
     *
     * @return mixed
     */
    public function removeInstallmentPaymentsFromSession()
    {
        return $this->getSession()->removeInstallmentPayments();
    }

}
