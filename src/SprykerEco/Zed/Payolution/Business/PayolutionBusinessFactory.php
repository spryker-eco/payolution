<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Payolution\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\Payolution\Business\Api\Adapter\Http\Guzzle;
use SprykerEco\Zed\Payolution\Business\Api\Converter\Converter;
use SprykerEco\Zed\Payolution\Business\Log\TransactionStatusLog;
use SprykerEco\Zed\Payolution\Business\Order\Saver;
use SprykerEco\Zed\Payolution\Business\Payment\Handler\Calculation\Calculation;
use SprykerEco\Zed\Payolution\Business\Payment\Handler\Transaction\Transaction;
use SprykerEco\Zed\Payolution\Business\Payment\Method\ApiConfig;
use SprykerEco\Zed\Payolution\Business\Payment\Method\Installment\Installment;
use SprykerEco\Zed\Payolution\Business\Payment\Method\Invoice\Invoice;
use SprykerEco\Zed\Payolution\PayolutionDependencyProvider;

/**
 * @method \SprykerEco\Zed\Payolution\Persistence\PayolutionQueryContainerInterface getQueryContainer()
 * @method \SprykerEco\Zed\Payolution\PayolutionConfig getConfig()
 */
class PayolutionBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \SprykerEco\Zed\Payolution\Business\Payment\Handler\Transaction\TransactionInterface
     */
    public function createPaymentTransactionHandler()
    {
        $paymentTransactionHandler = new Transaction(
            $this->createAdapter($this->getConfig()->getTransactionGatewayUrl(), ApiConfig::TRANSACTION_REQUEST_CONTENT_TYPE),
            $this->createConverter(),
            $this->getQueryContainer(),
            $this->getConfig()
        );

        $paymentTransactionHandler->registerMethodMapper(
            $this->createInvoice()
        );
        $paymentTransactionHandler->registerMethodMapper(
            $this->createInstallment()
        );

        return $paymentTransactionHandler;
    }

    /**
     * @return \SprykerEco\Zed\Payolution\Business\Payment\Handler\Calculation\CalculationInterface
     */
    public function createPaymentCalculationHandler()
    {
        $paymentCalculationHandler = new Calculation(
            $this->createAdapter($this->getConfig()->getCalculationGatewayUrl(), ApiConfig::CALCULATION_REQUEST_CONTENT_TYPE),
            $this->createConverter(),
            $this->getConfig()
        );

        $paymentCalculationHandler->registerMethodMapper(
            $this->createInstallment()
        );

        return $paymentCalculationHandler;
    }

    /**
     * @param string $gatewayUrl
     * @param string $contentType
     *
     * @return \SprykerEco\Zed\Payolution\Business\Api\Adapter\AdapterInterface
     */
    protected function createAdapter($gatewayUrl, $contentType)
    {
        return new Guzzle($gatewayUrl, $contentType);
    }

    /**
     * @return \SprykerEco\Zed\Payolution\Business\Order\SaverInterface
     */
    public function createOrderSaver()
    {
        return new Saver();
    }

    /**
     * @return \SprykerEco\Zed\Payolution\Business\Api\Converter\ConverterInterface
     */
    public function createConverter()
    {
        return new Converter($this->getMoneyFacade());
    }

    /**
     * @return \SprykerEco\Zed\Payolution\Dependency\Facade\PayolutionToMoneyInterface
     */
    protected function getMoneyFacade()
    {
        return $this->getProvidedDependency(PayolutionDependencyProvider::FACADE_MONEY);
    }

    /**
     * @return \SprykerEco\Zed\Payolution\Business\Log\TransactionStatusLogInterface
     */
    public function createTransactionStatusLog()
    {
        return new TransactionStatusLog($this->getQueryContainer());
    }

    /**
     * @return \SprykerEco\Zed\Payolution\Business\Payment\Method\Invoice\InvoiceInterface
     */
    protected function createInvoice()
    {
        return new Invoice($this->getConfig(), $this->getMoneyFacade());
    }

    /**
     * @return \SprykerEco\Zed\Payolution\Business\Payment\Method\Installment\InstallmentInterface
     */
    protected function createInstallment()
    {
        return new Installment($this->getConfig(), $this->getMoneyFacade());
    }
}
