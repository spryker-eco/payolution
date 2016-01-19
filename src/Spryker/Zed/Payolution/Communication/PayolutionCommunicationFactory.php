<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */
namespace Spryker\Zed\Payolution\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\Payolution\Communication\Table\Payments;
use Spryker\Zed\Payolution\Communication\Table\RequestLog;
use Spryker\Zed\Payolution\Communication\Table\StatusLog;
use Spryker\Zed\Payolution\Dependency\Facade\PayolutionToGlossaryInterface;
use Spryker\Zed\Payolution\Dependency\Facade\PayolutionToMailInterface;
use Spryker\Zed\Payolution\Dependency\Facade\PayolutionToSalesInterface;
use Spryker\Zed\Payolution\PayolutionConfig;
use Spryker\Zed\Payolution\Persistence\PayolutionQueryContainerInterface;
use Spryker\Zed\Payolution\PayolutionDependencyProvider;

/**
 * @method PayolutionQueryContainerInterface getQueryContainer()
 * @method PayolutionConfig getConfig()
 */
class PayolutionCommunicationFactory extends AbstractCommunicationFactory
{

    /**
     * @return Payments
     */
    public function createPaymentsTable()
    {
        $paymentPayolutionQuery = $this->getQueryContainer()->queryPayments();

        return new Payments($paymentPayolutionQuery);
    }

    /**
     * @param int $idPayment
     *
     * @return RequestLog
     */
    public function createRequestLogTable($idPayment)
    {
        $requestLogQuery = $this->getQueryContainer()->queryTransactionRequestLogByPaymentId($idPayment);

        return new RequestLog($requestLogQuery, $idPayment);
    }

    /**
     * @param int $idPayment
     *
     * @return StatusLog
     */
    public function createStatusLogTable($idPayment)
    {
        $statusLogQuery= $this->getQueryContainer()->queryTransactionStatusLogByPaymentId($idPayment);

        return new StatusLog($statusLogQuery, $idPayment);
    }

    /**
     * @return PayolutionToSalesInterface
     */
    public function getSalesFacade()
    {
        return $this->getProvidedDependency(PayolutionDependencyProvider::FACADE_SALES);
    }

    /**
     * @return PayolutionToMailInterface
     */
    public function getMailFacade()
    {
        return $this->getProvidedDependency(PayolutionDependencyProvider::FACADE_MAIL);
    }

    /**
     * @return PayolutionToGlossaryInterface
     */
    public function getGlossaryFacade()
    {
        return $this->getProvidedDependency(PayolutionDependencyProvider::FACADE_GLOSSARY);
    }

}
