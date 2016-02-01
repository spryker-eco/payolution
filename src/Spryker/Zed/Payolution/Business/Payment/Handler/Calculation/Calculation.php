<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Payolution\Business\Payment\Handler\Calculation;

use Generated\Shared\Transfer\PayolutionCalculationResponseTransfer;
use Generated\Shared\Transfer\CheckoutRequestTransfer;
use Spryker\Shared\Payolution\PayolutionConstants;
use Spryker\Zed\Payolution\Business\Payment\Handler\AbstractPaymentHandler;

class Calculation extends AbstractPaymentHandler implements CalculationInterface
{

    /**
     * @param CheckoutRequestTransfer $checkoutRequestTransfer
     *
     * @return \Generated\Shared\Transfer\PayolutionCalculationResponseTransfer
     */
    public function calculateInstallmentPayments(CheckoutRequestTransfer $checkoutRequestTransfer)
    {
        $requestData = $this
            ->getMethodMapper(PayolutionConstants::BRAND_INSTALLMENT)
            ->buildCalculationRequest($checkoutRequestTransfer);

        return $this->sendRequest($requestData);
    }

    /**
     * @param string $requestData
     *
     * @return \Generated\Shared\Transfer\PayolutionCalculationResponseTransfer
     */
    protected function sendRequest($requestData)
    {
        $calculationRequest = $this->converter->toCalculationRequest($requestData);
        $responseData = $this->executionAdapter->sendAuthorizedRequest(
            $calculationRequest,
            $this->getConfig()->getCalculationUserLogin(),
            $this->getConfig()->getCalculationUserPassword()
        );
        $responseTransfer = $this->converter->toCalculationResponseTransfer($responseData);

        return $responseTransfer;
    }

}
