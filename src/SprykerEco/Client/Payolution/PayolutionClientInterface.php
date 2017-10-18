<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Client\Payolution;

use Generated\Shared\Transfer\PayolutionCalculationResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface PayolutionClientInterface
{
    /**
     * Specification:
     * - Calculates installment payments
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\PayolutionCalculationResponseTransfer
     */
    public function calculateInstallmentPayments(QuoteTransfer $quoteTransfer);

    /**
     * Specification:
     * - Stores installment payments in session
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PayolutionCalculationResponseTransfer $payolutionCalculationResponseTransfer
     *
     * @return \Generated\Shared\Transfer\PayolutionCalculationResponseTransfer
     */
    public function storeInstallmentPaymentsInSession(PayolutionCalculationResponseTransfer $payolutionCalculationResponseTransfer);

    /**
     * Specification:
     * - Checks if session has saved installment payments
     *
     * @api
     *
     * @return bool
     */
    public function hasInstallmentPaymentsInSession();

    /**
     * Specification:
     * - Fetches saved installment payments from session
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\PayolutionCalculationResponseTransfer
     */
    public function getInstallmentPaymentsFromSession();

    /**
     * Specification:
     * - Removes saved installment payments from session
     *
     * @api
     *
     * @return bool
     */
    public function removeInstallmentPaymentsFromSession();
}
