<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Payolution\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use SprykerEco\Zed\Payolution\Communication\Table\Payments;
use SprykerEco\Zed\Payolution\Communication\Table\RequestLog;
use SprykerEco\Zed\Payolution\Communication\Table\StatusLog;
use SprykerEco\Zed\Payolution\PayolutionDependencyProvider;

/**
 * @method \SprykerEco\Zed\Payolution\Persistence\PayolutionQueryContainerInterface getQueryContainer()
 * @method \SprykerEco\Zed\Payolution\PayolutionConfig getConfig()
 * @method \SprykerEco\Zed\Payolution\Business\PayolutionFacadeInterface getFacade()
 */
class PayolutionCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \SprykerEco\Zed\Payolution\Communication\Table\GuiTableInterface
     */
    public function createPaymentsTable()
    {
        $paymentPayolutionQuery = $this->getQueryContainer()->queryPayments();

        return new Payments($paymentPayolutionQuery);
    }

    /**
     * @param int $idPayment
     *
     * @return \SprykerEco\Zed\Payolution\Communication\Table\GuiTableInterface
     */
    public function createRequestLogTable($idPayment)
    {
        $requestLogQuery = $this->getQueryContainer()->queryTransactionRequestLogByPaymentId($idPayment);

        return new RequestLog($requestLogQuery, $idPayment);
    }

    /**
     * @param int $idPayment
     *
     * @return \SprykerEco\Zed\Payolution\Communication\Table\GuiTableInterface
     */
    public function createStatusLogTable($idPayment)
    {
        $statusLogQuery = $this->getQueryContainer()->queryTransactionStatusLogByPaymentId($idPayment);

        return new StatusLog($statusLogQuery, $idPayment);
    }

    /**
     * @return \SprykerEco\Zed\Payolution\Dependency\Facade\PayolutionToMailInterface
     */
    public function getMailFacade()
    {
        return $this->getProvidedDependency(PayolutionDependencyProvider::FACADE_MAIL);
    }

    /**
     * @return \SprykerEco\Zed\Payolution\Dependency\Facade\PayolutionToGlossaryInterface
     */
    public function getGlossaryFacade()
    {
        return $this->getProvidedDependency(PayolutionDependencyProvider::FACADE_GLOSSARY);
    }

    /**
     * @return \SprykerEco\Zed\Payolution\Dependency\Facade\PayolutionToRefundInterface
     */
    public function getRefundFacade()
    {
        return $this->getProvidedDependency(PayolutionDependencyProvider::FACADE_REFUND);
    }

    /**
     * @return \SprykerEco\Zed\Payolution\Dependency\Facade\PayolutionToSalesInterface
     */
    public function getSalesFacade()
    {
        return $this->getProvidedDependency(PayolutionDependencyProvider::FACADE_SALES);
    }
}
