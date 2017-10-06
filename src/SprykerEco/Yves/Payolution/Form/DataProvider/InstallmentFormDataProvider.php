<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Payolution\Form\DataProvider;

use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\PayolutionCalculationPaymentDetailTransfer;
use Generated\Shared\Transfer\PayolutionCalculationResponseTransfer;
use Generated\Shared\Transfer\PayolutionPaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface;
use Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface;
use SprykerEco\Client\Payolution\PayolutionClientInterface;
use SprykerEco\Yves\Payolution\Exception\InstallmentNotFoundException;
use SprykerEco\Yves\Payolution\Form\InstallmentSubForm;

class InstallmentFormDataProvider implements StepEngineFormDataProviderInterface
{

    /**
     * @var \SprykerEco\Client\Payolution\PayolutionClientInterface
     */
    protected $payolutionClient;

    /**
     * @var \Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface
     */
    protected $moneyPlugin;

    /**
     * @param \SprykerEco\Client\Payolution\PayolutionClientInterface $payolutionClient
     * @param \Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface $moneyPlugin
     */
    public function __construct(PayolutionClientInterface $payolutionClient, MoneyPluginInterface $moneyPlugin)
    {
        $this->payolutionClient = $payolutionClient;
        $this->moneyPlugin = $moneyPlugin;
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer|\Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\AbstractTransfer
     */
    public function getData(AbstractTransfer $quoteTransfer)
    {
        if ($quoteTransfer->getPayment() === null) {
            $paymentTransfer = new PaymentTransfer();
            $paymentTransfer->setPayolution(new PayolutionPaymentTransfer());
            $paymentTransfer->setPayolutionInstallment(new PayolutionPaymentTransfer());
            $quoteTransfer->setPayment($paymentTransfer);
        }

        return $quoteTransfer;
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer|\Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array
     */
    public function getOptions(AbstractTransfer $quoteTransfer)
    {
        return [
            InstallmentSubForm::OPTION_INSTALLMENT_PAYMENT_DETAIL => $this->getInstallmentPaymentChoices(
                $quoteTransfer
            ),
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array
     */
    protected function getInstallmentPaymentChoices(QuoteTransfer $quoteTransfer)
    {
        $calculationResponseTransfer = $this->getInstallmentPayments($quoteTransfer);
        return $this->buildChoices($calculationResponseTransfer->getPaymentDetails());
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\PayolutionCalculationResponseTransfer
     */
    protected function getInstallmentPayments(QuoteTransfer $quoteTransfer)
    {
        if ($this->payolutionClient->hasInstallmentPaymentsInSession()) {
            $calculationResponseTransfer = $this->payolutionClient->getInstallmentPaymentsFromSession();

            if ($this->isInstallmentPaymentsStillValid($quoteTransfer, $calculationResponseTransfer)) {
                return $calculationResponseTransfer;
            }
        }

        $calculationResponseTransfer = $this->payolutionClient->calculateInstallmentPayments($quoteTransfer);
        return $this->payolutionClient->storeInstallmentPaymentsInSession($calculationResponseTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\PayolutionCalculationResponseTransfer $calculationResponseTransfer
     *
     * @return bool
     */
    protected function isInstallmentPaymentsStillValid(
        QuoteTransfer $quoteTransfer,
        PayolutionCalculationResponseTransfer $calculationResponseTransfer
    ) {
        if ($quoteTransfer->getTotals() === null) {
            return false;
        }

        return $quoteTransfer->getTotals()->getHash() === $calculationResponseTransfer->getTotalsAmountHash();
    }

    /**
     * @param \Generated\Shared\Transfer\PayolutionCalculationPaymentDetailTransfer[] $installmentPaymentDetails
     *
     * @return array
     */
    protected function buildChoices($installmentPaymentDetails)
    {
        $choices = [];
        foreach ($installmentPaymentDetails as $paymentDetail) {
            $choices[] = $this->buildChoice($paymentDetail);
        }

        return $choices;
    }

    /**
     * @param \Generated\Shared\Transfer\PayolutionCalculationPaymentDetailTransfer $paymentDetail
     *
     * @throws \SprykerEco\Yves\Payolution\Exception\InstallmentNotFoundException
     *
     * @return string
     */
    protected function buildChoice(PayolutionCalculationPaymentDetailTransfer $paymentDetail)
    {
        $installment = $paymentDetail->getInstallments()[0];
        if (!$installment) {
            throw new InstallmentNotFoundException('Could not get installment');
        }

        $moneyTransfer = $this->moneyPlugin
            ->fromInteger(
                $installment->getAmount(),
                $paymentDetail->getCurrency()
            );

        $choice = sprintf('%d × %s',
            $paymentDetail->getDuration(),
            $this->moneyPlugin->formatWithSymbol($moneyTransfer)
        );

        return $choice;
    }

}
