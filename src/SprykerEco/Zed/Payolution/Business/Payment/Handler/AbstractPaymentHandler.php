<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Payolution\Business\Payment\Handler;

use SprykerEco\Zed\Payolution\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Payolution\Business\Api\Converter\ConverterInterface;
use SprykerEco\Zed\Payolution\Business\Exception\NoMethodMapperException;
use SprykerEco\Zed\Payolution\Business\Exception\OrderGrandTotalException;
use SprykerEco\Zed\Payolution\PayolutionConfig;

abstract class AbstractPaymentHandler
{

    /**
     * @var \SprykerEco\Zed\Payolution\Business\Api\Adapter\AdapterInterface
     */
    protected $executionAdapter;

    /**
     * @var \SprykerEco\Zed\Payolution\Business\Api\Converter\ConverterInterface
     */
    protected $converter;

    /**
     * @var \SprykerEco\Zed\Payolution\PayolutionConfig
     */
    protected $config;

    /**
     * @var array
     */
    protected $methodMappers = [];

    /**
     * @param \SprykerEco\Zed\Payolution\Business\Api\Adapter\AdapterInterface $executionAdapter
     * @param \SprykerEco\Zed\Payolution\Business\Api\Converter\ConverterInterface $converter
     * @param \SprykerEco\Zed\Payolution\PayolutionConfig $config
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
     * @return \SprykerEco\Zed\Payolution\PayolutionConfig
     */
    protected function getConfig()
    {
        return $this->config;
    }

    /**
     * @param \SprykerEco\Zed\Payolution\Business\Payment\Method\Invoice\InvoiceInterface|\SprykerEco\Zed\Payolution\Business\Payment\Method\Installment\InstallmentInterface $mapper
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
     * @throws \SprykerEco\Zed\Payolution\Business\Exception\NoMethodMapperException
     *
     * @return \SprykerEco\Zed\Payolution\Business\Payment\Method\Invoice\InvoiceInterface|\SprykerEco\Zed\Payolution\Business\Payment\Method\Installment\InstallmentInterface
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
     * @throws \SprykerEco\Zed\Payolution\Business\Exception\OrderGrandTotalException
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
     * @param array|string $requestData
     *
     * @return \Generated\Shared\Transfer\PayolutionTransactionResponseTransfer|\Generated\Shared\Transfer\PayolutionCalculationResponseTransfer
     */
    abstract protected function sendRequest($requestData);

}
