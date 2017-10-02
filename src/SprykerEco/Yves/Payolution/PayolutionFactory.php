<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Payolution;

use Spryker\Yves\Kernel\AbstractFactory;
use Spryker\Yves\Money\Plugin\MoneyPlugin;
use SprykerEco\Yves\Payolution\Form\DataProvider\InstallmentFormDataProvider;
use SprykerEco\Yves\Payolution\Form\DataProvider\InvoiceFormDataProvider;
use SprykerEco\Yves\Payolution\Form\InstallmentSubForm;
use SprykerEco\Yves\Payolution\Form\InvoiceSubForm;
use SprykerEco\Yves\Payolution\Handler\PayolutionHandler;

class PayolutionFactory extends AbstractFactory
{

    /**
     * @return \SprykerEco\Yves\Payolution\Form\InvoiceSubForm
     */
    public function createInvoiceForm()
    {
        return new InvoiceSubForm();
    }

    /**
     * @return \SprykerEco\Yves\Payolution\Form\InstallmentSubForm
     */
    public function createInstallmentForm()
    {
        return new InstallmentSubForm();
    }

    /**
     * @return \SprykerEco\Yves\Payolution\Form\DataProvider\InstallmentFormDataProvider
     */
    public function createInstallmentFormDataProvider()
    {
        return new InstallmentFormDataProvider($this->getPayolutionClient(), $this->getMoneyPlugin());
    }

    /**
     * @return \Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface
     */
    public function getMoneyPlugin()
    {
        return new MoneyPlugin();
    }

    /**
     * @return \SprykerEco\Yves\Payolution\Form\DataProvider\InvoiceFormDataProvider
     */
    public function createInvoiceFormDataProvider()
    {
        return new InvoiceFormDataProvider();
    }

    /**
     * @return \SprykerEco\Yves\Payolution\Handler\PayolutionHandler
     */
    public function createPayolutionHandler()
    {
        return new PayolutionHandler($this->getPayolutionClient());
    }

    /**
     * @return \SprykerEco\Client\Payolution\PayolutionClientInterface
     */
    public function getPayolutionClient()
    {
        return $this->getProvidedDependency(PayolutionDependencyProvider::CLIENT_PAYOLUTION);
    }

}
