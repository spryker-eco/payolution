<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Client\Payolution\Zed;

use Generated\Shared\Transfer\QuoteTransfer;

interface PayolutionStubInterface
{

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\PayolutionCalculationResponseTransfer
     */
    public function calculateInstallmentPayments(QuoteTransfer $quoteTransfer);

}
