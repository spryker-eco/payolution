<?php
/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace SprykerFeature\Zed\Payolution\Business\Payment\Handler;

use Generated\Shared\Transfer\PayolutionCalculationResponseTransfer;
use SprykerFeature\Zed\Payolution\Business\Api\Adapter\AdapterInterface;
use SprykerFeature\Zed\Payolution\Business\Api\Converter\ConverterInterface;
use SprykerFeature\Zed\Payolution\Business\Exception\NoMethodMapperException;
use SprykerFeature\Zed\Payolution\Business\Exception\OrderGrandTotalException;
use Generated\Shared\Transfer\PayolutionTransactionResponseTransfer;
use SprykerFeature\Zed\Payolution\Business\Payment\Method\installment\InstallmentInterface;
use SprykerFeature\Zed\Payolution\Business\Payment\Method\invoice\InvoiceInterface;
use SprykerFeature\Zed\Payolution\PayolutionConfig;

abstract class AbstractPaymentHandler
{

    /**
     * @var AdapterInterface
     */
    protected $executionAdapter;

    /**
     * @var ConverterInterface
     */
    protected $converter;

    /**
     * @var PayolutionConfig
     */
    protected $config;

    /**
     * @var array
     */
    protected $methodMappers = [];

    /**
     * @param AdapterInterface $executionAdapter
     * @param ConverterInterface $converter
     * @param PayolutionConfig $config
     */
    public function __construct(
        AdapterInterface $executionAdapter,
        ConverterInterface $converter,
        PayolutionConfig $config
    ) {
        $this->executionAdapter = $executionAdapter;
        $this->converter = $converter;
        $this->config = $config;
    }

    /**
     * @return PayolutionConfig
     */
    protected function getConfig()
    {
        return $this->config;
    }

    /**
     * @param InvoiceInterface | InstallmentInterface $mapper
     *
     * @return void
     */
    public function registerMethodMapper($mapper)
    {
        $this->methodMappers[$mapper->getAccountBrand()] = $mapper;
    }

    /**
     * @param string $accountBrand
     *
     * @throws NoMethodMapperException
     *
     * @return InvoiceInterface | InstallmentInterface
     */
    protected function getMethodMapper($accountBrand)
    {
        if (isset($this->methodMappers[$accountBrand]) === false) {
            throw new NoMethodMapperException('The method mapper is not registered.');
        }

        return $this->methodMappers[$accountBrand];
    }

    /**
     * @param int $amount
     * @param int $min
     * @param int $max
     *
     * @throws OrderGrandTotalException
     *
     * @return void
     */
    protected function checkMaxMinGrandTotal($amount, $min, $max)
    {
        if ($amount < $min) {
            throw new OrderGrandTotalException('The grand total is less than the allowed minimum amount');
        }

        if ($amount > $max) {
            throw new OrderGrandTotalException('The grand total is greater than the allowed maximum amount');
        }
    }

    /**
     * @param array | string $requestData
     *
     * @return PayolutionTransactionResponseTransfer | PayolutionCalculationResponseTransfer
     */
    abstract protected function sendRequest($requestData);

}
