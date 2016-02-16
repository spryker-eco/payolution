<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Client\Payolution;

use Generated\Shared\Transfer\PayolutionCalculationResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Client\Kernel\AbstractClient;
use Spryker\Client\Payolution\Session\PayolutionSession;

/**
 * @method \Spryker\Client\Payolution\PayolutionFactory getFactory()
 */
class PayolutionClient extends AbstractClient implements PayolutionClientInterface
{

    /**
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
     * @return bool
     */
    public function hasInstallmentPaymentsInSession()
    {
        return $this->getSession()->hasInstallmentPayments();
    }

    /**
     * @return \Generated\Shared\Transfer\PayolutionCalculationResponseTransfer
     */
    public function getInstallmentPaymentsFromSession()
    {
        return $this->getSession()->getInstallmentPayments();
    }

    /**
     * @return mixed
     */
    public function removeInstallmentPaymentsFromSession()
    {
        return $this->getSession()->removeInstallmentPayments();
    }

}