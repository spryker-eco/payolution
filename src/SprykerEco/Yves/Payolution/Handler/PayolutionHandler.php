<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Payolution\Handler;

use Generated\Shared\Transfer\PayolutionPaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Kernel\Store;
use SprykerEco\Client\Payolution\PayolutionClientInterface;
use SprykerEco\Shared\Payolution\PayolutionConstants;
use SprykerEco\Yves\Payolution\Exception\PaymentMethodNotFoundException;
use Symfony\Component\HttpFoundation\Request;

class PayolutionHandler
{

    /**
     * @var array
     */
    protected static $paymentMethods = [
        PayolutionConstants::PAYMENT_METHOD_INVOICE => 'invoice',
        PayolutionConstants::PAYMENT_METHOD_INSTALLMENT => 'installment',
    ];

    /**
     * @var array
     */
    protected static $payolutionPaymentMethodMapper = [
        PayolutionConstants::PAYMENT_METHOD_INVOICE => PayolutionConstants::BRAND_INVOICE,
        PayolutionConstants::PAYMENT_METHOD_INSTALLMENT => PayolutionConstants::BRAND_INSTALLMENT,
    ];

    /**
     * @var array
     */
    protected static $payolutionGenderMapper = [
        'Mr' => 'Male',
        'Mrs' => 'Female',
    ];

    /**
     * @var \SprykerEco\Client\Payolution\PayolutionClientInterface
     */
    protected $payolutionClient;

    /**
     * @param \SprykerEco\Client\Payolution\PayolutionClientInterface $payolutionClient
     */
    public function __construct(PayolutionClientInterface $payolutionClient)
    {
        $this->payolutionClient = $payolutionClient;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function addPaymentToQuote(Request $request, QuoteTransfer $quoteTransfer)
    {
        $paymentSelection = $quoteTransfer->getPayment()->getPaymentSelection();

        $this->setPaymentProviderAndMethod($quoteTransfer, $paymentSelection);
        $this->setPayolutionPayment($request, $quoteTransfer, $paymentSelection);

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param string $paymentSelection
     *
     * @return void
     */
    protected function setPaymentProviderAndMethod(QuoteTransfer $quoteTransfer, $paymentSelection)
    {
        $quoteTransfer->getPayment()
            ->setPaymentProvider(PayolutionConstants::PROVIDER_NAME)
            ->setPaymentMethod(self::$paymentMethods[$paymentSelection]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param string $paymentSelection
     *
     * @return void
     */
    protected function setPayolutionPayment(Request $request, QuoteTransfer $quoteTransfer, $paymentSelection)
    {
        $payolutionPaymentTransfer = $this->getPayolutionPaymentTransfer($quoteTransfer, $paymentSelection);

        $billingAddress = $quoteTransfer->getBillingAddress();

        $payolutionPaymentTransfer
            ->setAccountBrand(self::$payolutionPaymentMethodMapper[$paymentSelection])
            ->setAddress($billingAddress)
            ->setGender(self::$payolutionGenderMapper[$billingAddress->getSalutation()])
            ->setEmail($quoteTransfer->getCustomer()->getEmail())
            ->setCurrencyIso3Code($this->getCurrency())
            ->setLanguageIso2Code($billingAddress->getIso2Code())
            ->setClientIp($request->getClientIp());

        if ($payolutionPaymentTransfer->getAccountBrand() === PayolutionConstants::BRAND_INSTALLMENT) {
            $this->setPayolutionInstallmentPayment($payolutionPaymentTransfer);
        }

        $quoteTransfer->getPayment()->setPayolution(clone $payolutionPaymentTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PayolutionPaymentTransfer $payolutionPaymentTransfer
     *
     * @return void
     */
    protected function setPayolutionInstallmentPayment(PayolutionPaymentTransfer $payolutionPaymentTransfer)
    {
        if ($this->payolutionClient->hasInstallmentPaymentsInSession() === false) {
            return;
        }

        $payolutionCalculationResponseTransfer = $this->payolutionClient->getInstallmentPaymentsFromSession();

        $installmentPaymentDetail = $payolutionCalculationResponseTransfer
            ->getPaymentDetails()[$payolutionPaymentTransfer->getInstallmentPaymentDetailIndex()];

        $payolutionPaymentTransfer
            ->setInstallmentCalculationId($payolutionCalculationResponseTransfer->getIdentificationUniqueid())
            ->setInstallmentAmount($installmentPaymentDetail->getInstallments()[0]->getAmount())
            ->setInstallmentDuration($installmentPaymentDetail->getDuration());
    }

    /**
     * @return string
     */
    protected function getCurrency()
    {
        return Store::getInstance()->getCurrencyIsoCode();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param string $paymentSelection
     *
     * @throws \SprykerEco\Yves\Payolution\Exception\PaymentMethodNotFoundException
     *
     * @return \Generated\Shared\Transfer\PayolutionPaymentTransfer
     */
    protected function getPayolutionPaymentTransfer(QuoteTransfer $quoteTransfer, $paymentSelection)
    {
        $paymentMethod = ucfirst($paymentSelection);
        $method = 'get' . $paymentMethod;
        $paymentTransfer = $quoteTransfer->getPayment();
        if (!method_exists($paymentTransfer, $method) || ($quoteTransfer->getPayment()->$method() === null)) {
            throw new PaymentMethodNotFoundException(sprintf('Selected payment method "%s" not found in PaymentTransfer', $paymentMethod));
        }
        $payolutionPaymentTransfer = $quoteTransfer->getPayment()->$method();

        return $payolutionPaymentTransfer;
    }

}
